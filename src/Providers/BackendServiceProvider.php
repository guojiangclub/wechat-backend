<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Providers;

use Event;
use iBrand\Wechat\Backend\Http\Middleware\AccountRequestMiddleware;
use iBrand\Wechat\Backend\Http\Middleware\Bootstrap;
use iBrand\Wechat\Backend\Services\AccountService;
use iBrand\Wechat\Backend\Services\CardService;
use iBrand\Wechat\Backend\Services\CouponService;
use iBrand\Wechat\Backend\Services\FanService;
use iBrand\Wechat\Backend\Services\MaterialService;
use iBrand\Wechat\Backend\Services\MenuService;
use iBrand\Wechat\Backend\Services\MessageService;
use iBrand\Wechat\Backend\Services\NoticeService;
use iBrand\Wechat\Backend\Services\PlatformService;
use iBrand\Wechat\Backend\Services\QRCodeService;
use iBrand\Wechat\Backend\Services\DataService;
use iBrand\Wechat\Backend\WechatBackend;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * 要注册的订阅者类。
     *
     * @var array
     */
    protected $subscribe = [
        /*'iBrand\Wechat\Backend\Listeners\WeChatLoginEventListener',*/
    ];

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'iBrand\Wechat\Backend\Http\Controllers';

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'admin.wechat.bootstrap' => Bootstrap::class,
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            $this->mapWebRoutes();
        }

        WechatBackend::boot();

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'wechat-backend');

        //publish a config file
        $this->publishes([
            __DIR__ . '/../../config/material.php' => config_path('ibrand/wechat-material.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../config/wechat-error-code.php' => config_path('ibrand/wechat-error-code.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../resources/assets' => public_path('assets/wechat-backend'),
            ], 'wechat-backend-assets');

            $this->registerMigrations();
        }
        //$this->registerMenu();

        // 使用类来指定视图组件
        if (request()->is('admin/wechat/*')) {
            view()->composer('*', 'iBrand\Wechat\Backend\Composers\WechatComposer');
        }

        // view()->share('key', 'value444');

        foreach ($this->subscribe as $item) {
            Event::subscribe($item);
        }
    }

    public function register()
    {

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Wechat');

        //注册服务
        $this->app->singleton('AccountService', function ($app) {
            return new AccountService();
        });

        $this->app->singleton('MenuService', function ($app) {
            return new MenuService();
        });

        /*$this->app->singleton('ServerService', function ($app) {
           return new ServerService();
        });*/

        $this->app->singleton('wechat.platform', function ($app) {
            return new PlatformService();
        });

        $this->app->singleton('MaterialService', function ($app) {
            return new MaterialService();
        });

        $this->app->singleton('NoticeService', function ($app) {
            return new NoticeService();
        });

        $this->app[\Illuminate\Routing\Router::class]->aliasMiddleware('wechat_account', AccountRequestMiddleware::class);

        $this->app->singleton('CardService', function ($app) {
            return new CardService();
        });

        $this->app->singleton('CouponService', function ($app) {
            return new CouponService();
        });

        $this->app->singleton('FanService', function ($app) {
            return new FanService();
        });

        $this->app->singleton('MessageService', function ($app) {
            return new MessageService();
        });

        $this->app->singleton('QRCodeService', function ($app) {
            return new QRCodeService();
        });

        $this->app->singleton('DataService', function ($app) {
            return new DataService();
        });


        $this->registerRouteMiddleware();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes()
    {
        Route::group([
//            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require __DIR__ . '/../Http/routes.php';
            require __DIR__ . '/../Http/api.php';
        });
    }

    /*private function registerMenu()
    {
       Menu::make('topMenu', function($menu){
            $menu->add('微信管理',['url' => 'admin/wechat', 'secure' => env('SECURE')])->active('admin/wechat/*');
       });
    }*/

    /**
     * 数据迁移.
     */
    protected function registerMigrations()
    {
        return $this->loadMigrationsFrom(__DIR__ . '/../../migrations');
    }

    private function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        app('router')->pushMiddlewareToGroup('admin','admin.wechat.bootstrap');
    }
}
