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
use iBrand\Wechat\Backend\Repository\ScanRepository;
use iBrand\Wechat\Backend\Repository\EventRepository;
use Illuminate\Http\Request;
use Session;
use iBrand\Wechat\Backend\Facades\DataService;
use Carbon\Carbon;

class WechatController extends Controller
{
    protected $accountRepository;
    protected $eventRepository;
    protected $scanRepository;

    public function __construct(AccountRepository $AccountRepository,
                                EventRepository $eventRepository,
    ScanRepository $scanRepository

    )
    {
        $this->accountRepository = $AccountRepository;
        $this->eventRepository = $eventRepository;
        $this->scanRepository=$scanRepository;
    }

    public function index()
    {
        if (!Session::has('account_app_id')) {

            return redirect()->route('admin.wechat.account.index');
        }


        //粉丝

        $to=date('Y-m-d',Carbon::parse('-1 days')->timestamp);

        $form=date('Y-m-d',Carbon::parse('-7 days')->timestamp);

        $fans=DataService::dataCube($form,$to,'userCumulate');

        $fans_data=[];

        if(isset($fans->list) AND count($fans->list)>0){
            foreach ($fans->list as $item){
                 $fans_data['ref_date'][]=$item->ref_date;
                 $fans_data['cumulate_user'][]=$item->cumulate_user;
            }
        }

        //图文
        $to=date('Y-m-d',Carbon::parse('-1 days')->timestamp);

        $form=date('Y-m-d',Carbon::parse('-3 days')->timestamp);

        $article=DataService::dataCube($form,$to,'userReadSummary');

        $article_data=[];

        $article_data['ref_date']=[$form,date('Y-m-d',Carbon::parse('-2 days')->timestamp),$to];

        $int_page_read_count=[];

        if(isset($article->list) AND count($article->list)>0){
            foreach ($article->list as $item){
                $int_page_read_count[$item->ref_date]=$item->int_page_read_count;
            }
        }

        foreach ($article_data['ref_date'] as $item){
            if(isset($int_page_read_count[$item])){
                $article_data['int_page_read_count'][]=$int_page_read_count[$item];
            }else{
                $article_data['int_page_read_count'][]=0;
            }
        }

        //扫码
        $today = Carbon::today()->timestamp;
        $tomorrow = Carbon::tomorrow()->timestamp;
        $scan_data['ref_date']=[
            date('Y-m-d', strtotime("-6 day", $today)),
              date('Y-m-d', strtotime("-5 day", $today)),
                date('Y-m-d', strtotime("-4 day", $today)),
                    date('Y-m-d', strtotime("-3 day", $today)),
                        date('Y-m-d', strtotime("-2 day", $today)),
                          date('Y-m-d', strtotime("-1 day", $today)),
                            date('Y-m-d', strtotime("0 day", $today)),
            ];

        $scan_data['count']=[
            $this->scanRepository->getScanCountDayByAppID(wechat_app_id(),-6),
            $this->scanRepository->getScanCountDayByAppID(wechat_app_id(),-5),
            $this->scanRepository->getScanCountDayByAppID(wechat_app_id(),-4),
            $this->scanRepository->getScanCountDayByAppID(wechat_app_id(),-3),
            $this->scanRepository->getScanCountDayByAppID(wechat_app_id(),-2),
            $this->scanRepository->getScanCountDayByAppID(wechat_app_id(),-1),
            $this->scanRepository->getScanCountDayByAppID(wechat_app_id(),0),

        ];

        return Admin::content(function (Content $content) use($fans_data,$article_data,$scan_data) {
            $content->description('数据统计');
            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '数据统计']
            );
            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->body(view('Wechat::wechat.index',compact('fans_data','article_data','scan_data')));
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
                ['text' => '微信设置','left-menu-active' => '微信设置']
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
