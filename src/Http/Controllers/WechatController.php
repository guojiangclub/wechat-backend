<?php namespace iBrand\Wechat\Backend\Http\Controllers;

use iBrand\Wechat\Backend\Services\PlatformService;
use Illuminate\Http\Request;

use App\Http\Requests;

use  iBrand\Wechat\Backend\Models\Account;
use iBrand\Wechat\Backend\Repository\AccountRepository;
use iBrand\Wechat\Backend\Repository\EventRepository;

use iBrand\Wechat\Backend\Facades\AccountService;
use Session;
use Laracasts\Flash;


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
        return view('Wechat::wechat.index');
    }



    public function platformAuth()
    {
        return redirect(app('system_setting')->getSetting('wechat_api_url') . 'platform/auth?client_id=' . app('system_setting')->getSetting('wechat_api_client_id') . '&redirect_url=' .
            route('admin.wechat.account.index'));
    }


         // 微信初始化
        public function wechatInit(){

            return view('Wechat::index');
        }

      // 授权
      public function saveSettings(Request $request)
        {
            $data = $request->except('_token');

            settings()->setSetting($data);

            if(empty(wechat_platform()->getToken())){
                return $this->api(false,400,'授权失败，请仔细核对授权信息',[]);
            }
            if($res=$this->accountRepository->findWhere(['app_id'=>$data['wechat_app_id']])->first()){
                $this->accountRepository->update(['main'=>1],$res->id);
            }else{
                if($res=$this->accountRepository->findWhere(['main'=>1])->first()){
                    $this->accountRepository->update(['main'=>0],$res->id);
                }
            }
            return $this->api(true,200,'',[]);
        }






}
