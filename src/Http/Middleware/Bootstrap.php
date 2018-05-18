<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9
 * Time: 12:41
 */

namespace iBrand\Wechat\Backend\Http\Middleware;

use Encore\Admin\Facades\Admin;
use iBrand\Backend\Backend;
use Illuminate\Http\Request;

class Bootstrap
{
    public function handle(Request $request, \Closure $next)
    {

        Admin::css('/assets/wechat-backend/css/menu.css');
        Admin::css('/assets/wechat-backend/css/fans.css');
        Admin::css('/assets/wechat-backend/libs/element/index.css');
        Admin::css('/assets/wechat-backend/libs/ladda/ladda-themeless.min.css');
        Admin::css('/assets/wechat-backend/css/upload.css');

        Backend::js('/assets/wechat-backend/js/loading.js');
        Backend::js('/assets/wechat-backend/libs/element/vue.js');
        Backend::js('/assets/wechat-backend/libs/element/index.js');
        Backend::js('/assets/wechat-backend/libs/ladda/spin.min.js');
        Backend::js('/assets/wechat-backend/libs/ladda/ladda.min.js');
        Backend::js('/assets/wechat-backend/libs/ladda/ladda.jquery.min.js');
        Backend::js('/assets/wechat-backend/js/common.js');

        return $next($request);
    }

}