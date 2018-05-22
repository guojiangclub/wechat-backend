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
use  Encore\Admin\Layout\Content;
use iBrand\Wechat\Backend\Models\Account;
use iBrand\Wechat\Backend\Repository\AccountRepository;
use iBrand\Wechat\Backend\Repository\EventRepository;
use Illuminate\Http\Request;
use Session;

class WechatController extends Controller
{
    protected $accountRepository;
    protected $eventRepository;

    public function __construct(AccountRepository $AccountRepository, EventRepository $eventRepository)
    {
        $this->accountRepository = $AccountRepository;
        $this->eventRepository = $eventRepository;
    }

    public function index()
    {
        if (!Session::has('account_app_id')) {
            return redirect()->route('admin.wechat.account.index');
        }

        return Admin::content(function (Content $content) {
            $content->body(view('Wechat::wechat.index'));
        });
    }

    public function platformAuth()
    {
        return redirect(app('system_setting')->getSetting('wechat_api_url').'platform/auth?client_id='.app('system_setting')->getSetting('wechat_api_client_id').'&redirect_url='.
            route('admin.wechat.account.index'));
    }

    // 微信初始化
    public function wechatInit()
    {
        return Admin::content(function (Content $content) {
            $content->description('微信设置');
            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '公众号管理', 'url' => 'wechat/account','no-pjax'=>1],
                ['text' => '微信设置']
            );
            $content->body(view('Wechat::index'));
        });
    }

    // 授权
    public function saveSettings(Request $request)
    {

        $data = $request->except('_token');

        settings()->setSetting($data);


        if (empty(wechat_platform()->getToken())) {
            return $this->api(false, 400, '授权失败，请仔细核对授权信息', []);
        }


        if(isset($data['wechat_app_id'])){
            if ($res = $this->accountRepository->findWhere(['app_id' => $data['wechat_app_id']])->first()) {
                $this->accountRepository->update(['main' => 1], $res->id);
            } else {
                if ($res = $this->accountRepository->findWhere(['main' => 1])->first()) {
                    $this->accountRepository->update(['main' => 0], $res->id);
                }
            }
        }


        return $this->api(true, 200, '', []);
    }
}
