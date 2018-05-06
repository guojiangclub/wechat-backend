<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Composers;

use Auth;
use iBrand\Wechat\Backend\Facades\AccountService;
use iBrand\Wechat\Backend\Repository\AccountRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;

/**
 * 后台视图组织.
 */
class WechatComposer
{
    /**
     * request.
     *
     * @var Illuminate\Http\Request
     */
    private $request;

    /**
     * accountService.
     */
    private $accountRepository;

    public function __construct(
        Request $request,
        AccountRepository $accountRepository
    ) {
        $this->request = $request;
        $this->accountRepository = $accountRepository;
    }

    /**
     * compose.
     *
     * @param View $view 视图对象
     */
    public function compose(View $view)
    {
        $global = new Fluent();
        $global->user = Auth::user();
        $global->current_account = app('AccountService');
        /*$global->accounts = $this->accountRepository->getAccountPaginated([]);*/
        $view->with('global', $global);
    }
}
