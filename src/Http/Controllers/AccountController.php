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

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use  iBrand\Wechat\Backend\Models\Account;
use iBrand\Wechat\Backend\Repository\AccountRepository;
use Illuminate\Http\Request;
use Session;
use Validator;

class AccountController extends Controller
{
    protected $accountRepository;
    protected $eventRepository;

    public function __construct(AccountRepository $AccountRepository)
    {
        $this->accountRepository = $AccountRepository;
    }

    /**
     * 公众号列表.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        if (empty(wechat_platform()->getToken())) {
            Session::pull('account_app_id');
            Session::pull('account_id');

            return redirect()->route('admin.wechat.init');
        }
        $accounts = wechat_platform()->getWechatAccounts();

        if (isset($accounts->errmsg)) {
            admin_toastr($accounts->errmsg,'error');
            $accounts = [];
        } else {
            $accounts = $this->accountRepository->createAccountByAppID($accounts);
        }

        return Admin::content(function (Content $content) use ($accounts) {
            $content->description('公众号列表');
            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '公众号管理', 'url' => 'wechat/account','no-pjax'=>1],
                ['text' => '公众号列表','left-menu-active' => '公众号列表']
            );
            $view = view('wechat-backend::account.index', compact('accounts'))->render();
            $content->row($view);
        });
    }

    /**
     * 添加公众号页面.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->body(view('wechat-backend::account.create'));
        });
    }

    /**
     * 添加公众号.
     */
    public function store(Request $request)
    {
        $rules = [
            'app_id' => 'required|unique:we_accounts,app_id',
            'name' => 'required',
            'original_id' => 'required|unique:we_accounts',
            'wechat_account' => 'required|unique:we_accounts',
        ];
        $message = [
            'required' => ':attribute 不能为空',
            'unique' => ':attribute 已经存在',
        ];

        $attributes = [
            'app_id' => 'App_ID',
            'original_id' => '公众号原始id',
            'wechat_account' => '微信号',
        ];

        $validator = Validator::make(
            $request->all(),
            $rules,
            $message,
            $attributes
        );
        if ($validator->fails()) {
            $warnings = $validator->messages();
            $show_warning = $warnings->first();

            return response()->json([
                'success' => false, 'error_code' => 0, 'error' => $show_warning,
            ]);
        }

        if (!empty($request->all())) {
            $data = $request->except('_token');
            $account = $this->accountRepository->createAccount($data);

            return response()->json([
                'error_code' => 0, 'error' => '', 'data' => $account->id, ]);
        }
    }

    /**
     * 编辑公众号.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $account = $this->accountRepository->findOrThrowException($id);

        return Admin::content(function (Content $content) use ($account) {
            $content->description('编辑公众号');
            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '公众号管理', 'url' => 'wechat/account','no-pjax'=>1],
                ['text' => '公众号列表','url' => 'wechat/account','no-pjax'=>1],
                ['text' => '编辑公众号','left-menu-active' => '公众号列表']
            );
            $content->body(view('wechat-backend::account.edit', compact('account')));
        });
    }

    /**
     * 更新公众号.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
//            $rules = array(
//                'app_id' => "required|unique:we_accounts,app_id,$id",
//                'original_id' => "required|unique:we_accounts,original_id,$id",
//                'wechat_account' => "required",
//                'name' => 'required',
//            );
//            $message = array(
//                "required" => ":attribute 不能为空",
//                "unique"=>":attribute 已经存在",
//            );
//
//            $attributes = array(
//                "app_id" => 'App_ID',
//                "original_id"=>"公众号原始id",
//                "wechat_account"=>"微信号"
//            );
//
//            $validator = Validator::make(
//                $request->all(),
//                $rules,
//                $message,
//                $attributes
//            );
//            if ($validator->fails()) {
//                $warnings = $validator->messages();
//                $show_warning = $warnings->first();
//
//                return response()->json([
//                    'success' => false
//                    , 'error_code' => 0
//                    , 'error' => $show_warning
//                ]);
//            }

        if (!empty($request->all())) {
            $data = $request->except('_token');
            if (isset($data['main']) && 'on' === $data['main']) {
                $data['main'] = 1;
            } else {
                $data['main'] = 0;
                Session::pull('account_app_id');
            }

            $account = $this->accountRepository->updateAccount($data, $id);

            if ($account and 1 == $account->main) {
                settings()->setSetting(['wechat_app_id' => $account->app_id]);
            }

            return $this->api(true, 200, '', []);
        }
    }

    /**删除公众号
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy($id)
    {
        $data = $this->accountRepository->find($id);
        if (wechat_platform()->DelAccounts($data->app_id)) {
            if ($data->app_id == wechat_app_id()) {
                Session::pull('account_app_id');
                Session::pull('account_id');
                Session::pull('account_name');
            }
            $this->accountRepository->destroy($id);
        }

        return $this->api(true, 200, '', []);
    }

    /**
     * 切换公众号.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getChangeAccount(Request $request, $app_id)
    {
        $main = $this->accountRepository->findWhere(['main' => 1])->first();
        if (null == $main) {
            Session::pull('account_app_id');
            admin_toastr('编辑并完善公众号信息（设置主微信公众号）','error');
            return redirect()->back();
        }

        $id = request('id');
        $name = request('name');
        if (!empty($app_id) && !empty($id) && !empty($name)) {
            Session::put('account_app_id', $app_id);
            Session::put('account_id', $id);
            Session::put('account_name', $name);

            return redirect()->route('admin.wechat.index');
        }

        admin_toastr('编辑并完善公众号信息（设置主微信公众号）','error');
        Session::pull('account_app_id');
        Session::pull('account_id');
        Session::pull('account_name');

        return redirect()->back();
    }
}
