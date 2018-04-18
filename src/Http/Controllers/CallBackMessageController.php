<?php
namespace iBrand\Wechat\Backend\Http\Controllers;

use Illuminate\Http\Request;
use iBrand\Wechat\Backend\Repository\MessageRepository;
use iBrand\Wechat\Backend\Repository\AccountRepository;
use iBrand\Wechat\Backend\Facades\MessageService;
use iBrand\Wechat\Backend\Models\Account;



use Log;
/**
 * 回调消息处理
 *
 */
class CallBackMessageController extends Controller
{
    protected $accountRepository;

    public function __construct(
        AccountRepository $accountRepository
    )
    {
        $this->accountRepository=$accountRepository;

    }


    //文本消息处理
    public function index()
    {
        $input = request()->all();
        $account=Account::where('app_id',$input['app_id'])->first();
        if(!isset($account->id)) return [];
        $accountId=$account->id;
        switch ($input['type']) {
            //文本信息处理
            case 'text':
                if($input['content']=='客服'){
                    if ($kf_account = MessageService::getStaffOnLines([], $input['app_id'])) {
                        MessageService::getStaffSession(['kf_account' => $kf_account, 'openid' => $input['open_id']], $input['app_id']);
                    } else {
                        return MessageService::CallBack($accountId, '无客服在线', $input['app_id'], $input['open_id']);
                    }
                }
                 return MessageService::CallBack($accountId,$input['content'],$input['app_id'],$input['open_id']);
                 break;
        }

    }














}
