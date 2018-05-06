<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend;

use Encore\Admin\Admin;
use Encore\Admin\Extension;
use iBrand\Wechat\Backend\Seeds\WechatBackendTablesSeeder;
use Illuminate\Support\Facades\Artisan;

class WechatBackend extends Extension
{
    /**
     * Bootstrap this package.
     */
    public static function boot()
    {
        Admin::extend('ibrand-wechat-backend', __CLASS__);
    }

    /**
     * {@inheritdoc}
     */
    public static function import()
    {
        Artisan::call('migrate', ['--path' => __DIR__.'/../seeds']);

        Artisan::call('db:seed', ['--class' => WechatBackendTablesSeeder::class]);
    }
}
