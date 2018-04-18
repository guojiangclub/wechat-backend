<?php

namespace  iBrand\Wechat\Backend\Http\Middleware;

use Closure;
use Response;
use Session;
use Illuminate\Contracts\Auth\Guard;

class ApiRequestMiddleware
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->is('admin/wechat-api/*')){
            if(empty(wechat_platform()->getToken())){
                return response()->json(
                       ['status' => false
                        , 'code' => 400
                        , 'message' => '未授权验证'
                        , 'data' => ['url'=>route('admin.wechat.init')]]);
            }

            if(empty(wechat_platform()->getMainAccount())){
                return response()->json(
                    ['status' => false
                        , 'code' => 400
                        , 'message' => '未设置主公众号'
                        , 'data' => ['url'=>route('admin.wechat.account.index')]]);
            }

        }

        return $next($request);
    }



}