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

use iBrand\Wechat\Backend\Facades\MessageService;
use iBrand\Wechat\Backend\Models\Account;
use iBrand\Wechat\Backend\Repository\AccountRepository;
use Illuminate\Http\Request;

/**
 * 回调消息处理.
 */
class CallBackMessageController extends Controller
{
    protected $accountRepository;

    public function __construct(
        AccountRepository $accountRepository
    ) {
        $this->accountRepository = $accountRepository;
    }

    //文本消息处理
    public function index()
    {
        $input = request()->all();
        $account = Account::where('app_id', $input['app_id'])->first();
        if (!isset($account->id)) {
            return [];
        }
        $accountId = $account->id;
        switch ($input['type']) {
            //文本信息处理
            case 'text':
                if ('客服' == $input['content']) {
                    if ($kf_account = MessageService::getStaffOnLines([], $input['app_id'])) {
                        MessageService::getStaffSession(['kf_account' => $kf_account, 'openid' => $input['open_id']], $input['app_id']);
                    } else {
                        return MessageService::CallBack($accountId, '无客服在线', $input['app_id'], $input['open_id']);
                    }
                }

                 return MessageService::CallBack($accountId, $input['content'], $input['app_id'], $input['open_id']);
                 break;
        }
    }
}
