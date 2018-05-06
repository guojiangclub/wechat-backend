<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Http\Controllers;

use App\Http\Controllers\Controller;
use iBrand\Wechat\Backend\Repository\AccountRepository;
use iBrand\Wechat\Backend\Services\ServerService;
use Illuminate\Http\Request;

/**
 * 微信服务通讯.
 */
class ServerController extends Controller
{
    /**
     * @var ServerService
     */
    private $server;

    /**
     * ServerController constructor.
     *
     * @param ServerService $ServerService
     */
    public function __construct(ServerService $ServerService)
    {
        $this->server = $ServerService;
    }

    /**
     * 返回服务端.
     *
     * @return Response
     */
    public function server(Request $request, AccountRepository $repository)
    {
        $account = $repository->getAccountByTag($request->t);

        if (!$account) {
            return;
        }

        $a = new ServerService();
        $b = $a->make($account);

        return $b;

        return ServerService::make($account);
    }
}
