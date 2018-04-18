<?php

namespace iBrand\Wechat\Backend\Http\Controllers;

use Illuminate\Http\Request;
use iBrand\Wechat\Backend\Services\ServerService;
use iBrand\Wechat\Backend\Repository\AccountRepository;

use App\Http\Controllers\Controller;
use iBrand\Wechat\Backend\Facades\AccountService;

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

        $a=new ServerService();
        $b=$a->make($account);

        return $b;

        return ServerService::make($account);
    }


}
