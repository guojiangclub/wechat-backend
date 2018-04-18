<?php
namespace iBrand\Wechat\Backend\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use  iBrand\Wechat\Backend\Models\Account;
use iBrand\Wechat\Backend\Repository\AccountRepository;
use iBrand\Wechat\Backend\Repository\EventRepository;
use iBrand\Wechat\Backend\Facades\AccountService;
use Session;



class AccountController extends Controller
{
    protected $accountRepository;
    protected $eventRepository;

    public function __construct(AccountRepository $AccountRepository)
    {
        $this->accountRepository = $AccountRepository;

    }

    /**
     * 公众号列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(){
        if(empty(wechat_platform()->getToken())){
            Session::pull('account_app_id');
            Session::pull('account_id');
            return redirect()->route('admin.wechat.init');
        }
        $accounts =  wechat_platform()->getWechatAccounts();

        if(isset($accounts->errmsg)){
            flash($accounts->errmsg, 'danger');
            $accounts=[];
        }else{

            $accounts=$this->accountRepository->createAccountByAppID($accounts);
        }


        return view('Wechat::account.index',compact('accounts'));
    }



    /**
     * 添加公众号页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function create()
    {
        return view('Wechat::account.create');
    }


    /**
     * 添加公众号
     */
    public function store(Request $request){

        $rules = array(
            'app_id' => 'required|unique:we_accounts,app_id',
            'name' => 'required',
            'original_id' => 'required|unique:we_accounts',
            'wechat_account' => 'required|unique:we_accounts',
        );
        $message = array(
            "required" => ":attribute 不能为空",
            "unique"=>":attribute 已经存在",
        );

        $attributes = array(
            "app_id" => 'App_ID',
            "original_id"=>"公众号原始id",
            "wechat_account"=>"微信号"
        );

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
                'success' => false
                , 'error_code' => 0
                , 'error' => $show_warning
            ]);
        }

        if (!empty($request->all())) {
            $data = $request->except('_token');
            $account= $this->accountRepository->createAccount($data);
            return response()->json([
                'error_code' => 0
                , 'error' => ''
                , 'data' => $account->id]);
        }

    }



    /**
     * 编辑公众号
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

        public function edit($id){
            $account= $this->accountRepository->findOrThrowException($id);
            return view('Wechat::account.edit',compact('account'));
        }

        /**
         * 更新公众号
         * @param Request $request
         * @param $id
         * @return \Illuminate\Http\JsonResponse
         */

        public function update(Request $request,$id){
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
                if(isset($data['main'])&&$data['main']==='on'){
                    $data['main']=1;
                }else{
                    $data['main']=0;
                    Session::pull('account_app_id');
                }

                $account= $this->accountRepository->updateAccount($data,$id);

                if($account AND $account->main==1){
                    settings()->setSetting(['wechat_app_id'=>$account->app_id]);
                }
                return $this->api(true,200,'',[]);
            }
        }


    /**删除公众号
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy($id){

         $data=$this->accountRepository->find($id);
        if(wechat_platform()->DelAccounts($data->app_id)){
            if($data->app_id==wechat_app_id()){
                Session::pull('account_app_id');
                Session::pull('account_id');
                Session::pull('account_name');
            }
           $this->accountRepository->destroy($id);
        }
        return $this->api(true,200,'',[]);
    }


    /**
     * 切换公众号
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getChangeAccount(Request $request,$app_id)
    {
            $main=$this->accountRepository->findWhere(['main'=>1])->first();
            if($main==null){
                Session::pull('account_app_id');
                flash('编辑并完善公众号信息（设置主微信公众号）', 'danger');
                return redirect()->back();
            }

            $id=request('id');
            $name=request('name');
            if(!empty($app_id)&&!empty($id)&&!empty($name)){
                     Session::put('account_app_id', $app_id);
                     Session::put('account_id',$id);
                     Session::put('account_name',$name);
                   return redirect()->route('admin.wechat.index');
             }

            flash('编辑并完善公众号信息（设置主微信公众号）', 'danger');
            Session::pull('account_app_id');
            Session::pull('account_id');
            Session::pull('account_name');
           return redirect()->back();

    }

























}