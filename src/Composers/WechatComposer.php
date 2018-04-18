<?php
namespace iBrand\Wechat\Backend\Composers;

use iBrand\Wechat\Backend\Repository\AccountRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use iBrand\Wechat\Backend\Facades\AccountService;
use Auth;

/**
 * 后台视图组织.
 *
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
     *
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

            //        $menus = $this->request->is('admin/account*') ? config('menu.account') : config('menu.func');
            $global = new Fluent();
            $global->user = Auth::user();
//        $global->menus = $menus;
            $global->current_account = app('AccountService');
            $global->accounts = $this->accountRepository->getAccountPaginated([]);
            $view->with('global', $global);


    }
}
