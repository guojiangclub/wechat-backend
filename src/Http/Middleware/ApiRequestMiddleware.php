<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace  iBrand\Wechat\Backend\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Response;

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
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->is('admin/wechat-api/*')) {
            if (empty(wechat_platform()->getToken())) {
                return response()->json(
                       ['status' => false, 'code' => 400, 'message' => '未授权验证', 'data' => ['url' => route('admin.wechat.init')]]);
            }

            if (empty(wechat_platform()->getMainAccount())) {
                return response()->json(
                    ['status' => false, 'code' => 400, 'message' => '未设置主公众号', 'data' => ['url' => route('admin.wechat.account.index')]]);
            }
        }

        return $next($request);
    }
}
