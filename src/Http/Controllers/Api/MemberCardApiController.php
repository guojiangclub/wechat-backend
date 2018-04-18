<?php
namespace iBrand\Wechat\Backend\Http\Controllers\Api;

use iBrand\Wechat\Backend\Http\Controllers\Controller;
use iBrand\Wechat\Backend\Facades\CardService;
use iBrand\Wechat\Backend\Facades\MaterialService;
use Illuminate\Http\Request;
use iBrand\Wechat\Backend\Repository\MaterialRepository;
use Validator;
use iBrand\Wechat\Backend\Repository\CardCodeRepository;

/**
 * 会员卡券接口.
 *
 */
class MemberCardApiController extends Controller
{

    protected $main;

    protected $materialRepository;

    protected $cardCodeRepository;

    public function __construct(
        MaterialRepository $materialRepository,
        CardCodeRepository $cardCodeRepository
    )
    {
        $this->main = wechat_platform()->getMainAccount();
        $this->materialRepository=$materialRepository;
        $this->cardCodeRepository=$cardCodeRepository;

    }


    public function test(){

//        dd($this->cardCodeRepository->all());
        
        return view('Wechat::test');
    }


//    卡券颜色
    public function cardColors(){
       $res= CardService::cardColors($this->main->app_id);
       if(is_array($res)&&isset($res['errcode'])){
           return $this->api(false,$res['errcode'],$res['errmsg'],[]);
       }
       return $this->api(true,200,'',$res->colors);
    }

// 创建会员卡
    public function createCard(Request $request){
        $data=[];
        // 使用时间的类型
        $type=["DATE_TYPE_FIX_TIME_RANGE","DATE_TYPE_FIX_TERM","DATE_TYPE_PERMANENT"];

        $input= $request->except('_token');
//        base_info
        if(!isset($input['base_info'])||count($input['base_info'])<=0){
            return $this->api( false, 500,'缺少参数base_info[]', '接口访问失败');
        }
        $validator = Validator::make($input['base_info'],
            [
                'logo_url' => 'required',
                'brand_name'  => 'required',
                'title' => 'required',
                'color'=>'required',
                'code_type'=> 'required',
                'notice'=>'required',
                'description'=>'required',
            ],
            [
                'logo_url.required' => '卡券的商户base_info[logo_url]参数缺失',
                'brand_name.required'=> '商户名字base_info[brand_name]参数缺失',
                'color.required'=> '颜色base_info[color]参数缺失',
                'title.required' => '标题base_info[title]参数缺失',
                'code_type.required' => 'Code展示类型base_info[code_type]参数缺失',
                'notice.required'=>'卡券使用提醒base_info[notice]参数缺失',
                'description.required'=>'卡券使用说明base_info[notice]参数缺失',
            ]
        );

        if ($validator->fails()) {
            return $this->api( false, 500,$validator->errors(), '接口访问失败');
        }


        // especial

        if(!isset($input['especial'])||count($input['especial'])<=0){
            return $this->api( false, 500,'缺少参数especial[]', '接口访问失败');
        }

        $validator = Validator::make($input['especial'],
            [
                'prerogative' => 'required',
                'activate_url'  => 'required',
            ],
            [
                'prerogative.required' => '会员卡特权说明especial[prerogative]参数缺失',
                'activate_url.required'=> '会员卡激活地址especial[activate_url]参数缺失',
            ]
        );

        if ($validator->fails()) {
            return $this->api( false, 500,$validator->errors(), '接口访问失败');
        }


        if(!isset($input['base_info']['date_info']['type'])||empty($input['base_info']['date_info']['type'])){
            return $this->api( false, 500,'缺少有效期参数base_info[date_info][type]', '接口访问失败');
        }

        if(!in_array($input['base_info']['date_info']['type'],$type)){
            return $this->api( false, 500,'有效期参数base_info[date_info][type]类型错误', '接口访问失败');
        }

        // 有效期
        if($input['base_info']['date_info']['type']==="DATE_TYPE_FIX_TIME_RANGE"){
            if(!isset($input['base_info']['date_info']['begin_timestamp'])||empty($input['base_info']['date_info']['begin_timestamp'])){
                return $this->api( false, 500,'缺少起用时间参数base_info[date_info][begin_timestamp]', '接口访问失败');
            }
            if(!isset($input['base_info']['date_info']['end_timestamp'])||empty($input['base_info']['date_info']['end_timestamp'])){
                return $this->api( false, 500,'缺少结束时间参数base_info[date_info][end_timestamp]', '接口访问失败');
            }
        }
        if($input['base_info']['date_info']['type']==="DATE_TYPE_FIX_TERM"){
            if(!isset($input['base_info']['date_info']['fixed_term'])||empty($input['base_info']['date_info']['fixed_term'])){
                return $this->api( false, 500,'缺少参数base_info[date_info][fixed_term]', '接口访问失败');
            }
        }
        // 库存
        if(!isset($input['base_info']['sku']['quantity'])||empty($input['base_info']['sku']['quantity'])){
            return $this->api( false, 500,'缺少库存参数base_info[date_info][sku][quantity]', '接口访问失败');
        }

        $input['base_info']['get_limit']=isset($input['base_info']['get_limit'])?$input['base_info']['get_limit']:1;

        $input['especial']['supply_bonus']=false;

        $input['especial']['supply_balance']=false;

        $data["card"]["member_card"]["base_info"]=$input['base_info'];
        $data["card"]["member_card"]["especial"]=$input['especial'];


        $res=CardService::createCard($data,$this->main->app_id);

        if(is_array($res)&&isset($res['errcode'])){
            return $this->api(false,$res['errcode'],$res['errmsg'],[]);
        }

        return $this->api(true,200,'',$res);

    }


//    获取会员卡信息
    public function getCardInfo(Request $request){
        $data=[];
        $input= $request->except('_token');
        $validator = Validator::make($input,
            [
                'card_id' => 'required',
            ],
            [
                'card_id.required' => '参数card_id缺失',
            ]
        );

        if ($validator->fails()) {
            return $this->api( false, 500,$validator->errors(), '接口访问失败');
        }

        $data['card_id']=$input['card_id'];

        $res=CardService::getCardInfo($data,$this->main->app_id);


        if(is_array($res)&&isset($res['errcode'])){
            return $this->api(false,$res['errcode'],$res['errmsg'],[]);
        }

        return $this->api(true,200,'',$res);

    }


    // 会员卡生成二维码
    public function getCardQRCode(Request $request)
    {
        $data=[];
        $input= $request->except('_token');
        $validator = Validator::make($input,
            [
                'card_id' => 'required',
            ],
            [
                'card_id.required' => '参数card_id缺失',
            ]
        );

        if ($validator->fails()) {
            return $this->api( false, 500,$validator->errors(), '接口访问失败');
        }

        $data['cards']['action_name']="QR_CARD";
        $data['cards']['action_info']['card']['card_id']=$input['card_id'];

        $res=CardService::getCardQRCode($data,$this->main->app_id);

        if(is_array($res)&&isset($res['errcode'])){
            return $this->api(false,$res['errcode'],$res['errmsg'],[]);
        }

        return $this->api(true,200,'',$res);
    }


    // 获取会员卡Code
    public function getCode(Request $request)
    {
        $data=[];
        $input= $request->except('_token');
        $validator = Validator::make($input,
            [
                'card_id' => 'required',
                'open_id' =>'required',
            ],
            [
                'card_id.required' => '参数card_id缺失',
                'open_id.required' => '参数open_id缺失',
            ]
        );

        if ($validator->fails()) {
            return $this->api( false, 500,$validator->errors(), '接口访问失败');
        }

        $data['card_id']=$input['card_id'];
        $data['openid']=$input['open_id'];
        $app_id=empty($app_id)?wechat_app_id():$app_id;

        $res= $this->cardCodeRepository->findWhere(['appid'=>$app_id,'card_id'=>$data['card_id'],'openid'=>$data['openid']])->first();

        if(is_array($res)&&isset($res['errcode'])){
            return $this->api(false,$res['errcode'],$res['errmsg'],[]);
        }

        return $this->api(true,200,'',$res);
    }



    // 编辑更新会员卡信息
    public function updateCard(Request $request){

        $data=[];

        $input= $request->except('_token');

        $validator = Validator::make($input,
            [
                'card_id' => 'required',
            ],
            [
                'card_id.required' => '参数card_id缺失',
            ]
        );

        if ($validator->fails()) {
            return $this->api( false, 500,$validator->errors(), '接口访问失败');
        }

        $data['base_info']=isset($input['base_info'])?$input['base_info']:[];

        $data['especial']=isset($input['especial'])?$input['especial']:[];

        $data['card_id']=$input['card_id'];

        $res=CardService::updateCard($data,$this->main->app_id);

        if(is_array($res)&&isset($res['errcode'])){
            return $this->api(false,$res['errcode'],$res['errmsg'],[]);
        }

        return $this->api(true,200,'',$res);

    }

    // 会员卡激活
    public function membershipActivate(Request $request){
        $data=[];

        $input= $request->except('_token');

        $validator = Validator::make($input,
            [
                'card_id' => 'required',
                'code' => 'required',
                'membership_number' => 'required',
            ],
            [
                'card_id.required' => '参数card_id缺失',
                'membership_number.required' => '参数membership_number缺失',
                'code.required' => '参数code缺失',
            ]
        );

        if ($validator->fails()) {
            return $this->api( false, 500,$validator->errors(), '接口访问失败');
        }


        $res=CardService::membershipActivate($input,$this->main->app_id);

        if(is_array($res)&&isset($res['errcode'])){
            return $this->api(false,$res['errcode'],$res['errmsg'],[]);
        }

        return $this->api(true,200,'',$res);

    }

    //获取会员信息
    public function membershipGet(Request $request){
        $data=[];

        $input= $request->except('_token');

        $validator = Validator::make($input,
            [
                'card_id' => 'required',
                'code' => 'required',
            ],
            [
                'card_id.required' => '参数card_id缺失',
                'code.required' => '参数code缺失',
            ]
        );

        if ($validator->fails()) {
            return $this->api( false, 500,$validator->errors(), '接口访问失败');
        }


        $res=CardService::membershipGet($input,$this->main->app_id);

        if(is_array($res)&&isset($res['errcode'])){
            return $this->api(false,$res['errcode'],$res['errmsg'],[]);
        }

        return $this->api(true,200,'',$res);
    }

    //更新会员卡库存
    public function updateQuantity(Request $request){
        $data=[];

        $input= $request->except('_token');

        $validator = Validator::make($input,
            [
                'card_id' => 'required',
                'amount' => 'required',
            ],
            [
                'card_id.required' => '参数card_id缺失',
                'amount.required' => '参数amount缺失',
            ]
        );

        $data['card_id']=$input['card_id'];
        $data['amount']=intval($input['amount']);

        if ($validator->fails()) {
            return $this->api( false, 500,$validator->errors(), '接口访问失败');
        }


        $res=CardService::updateQuantity($data,$this->main->app_id);

        if(is_array($res)&&isset($res['errcode'])){
            return $this->api(false,$res['errcode'],$res['errmsg'],[]);
        }

        return $this->api(true,200,'',$res);

    }


    //删除会员卡
    public function deleteCard(Request $request){
        $data=[];

        $input= $request->except('_token');

        $validator = Validator::make($input,
            [
                'card_id' => 'required',
            ],
            [
                'card_id.required' => '参数card_id缺失',
            ]
        );

        $data['card_id']=$input['card_id'];

        if ($validator->fails()) {
            return $this->api( false, 500,$validator->errors(), '接口访问失败');
        }


        $res=CardService::deleteCard($data,$this->main->app_id);

        if(is_array($res)&&isset($res['errcode'])){
            return $this->api(false,$res['errcode'],$res['errmsg'],[]);
        }

        return $this->api(true,200,'',$res);
    }


    //指定会员卡失效
    public function disableCard(Request $request){
        $data=[];

        $input= $request->except('_token');

        $validator = Validator::make($input,
            [
                'card_id' => 'required',
                'code' => 'required',
            ],
            [
                'card_id.required' => '参数card_id缺失',
                'code.required' => '参数code缺失',
            ]
        );

        if ($validator->fails()) {
            return $this->api( false, 500,$validator->errors(), '接口访问失败');
        }


        $res=CardService::disableCard($input,$this->main->app_id);

        if(is_array($res)&&isset($res['errcode'])){
            return $this->api(false,$res['errcode'],$res['errmsg'],[]);
        }

        return $this->api(true,200,'',$res);
    }



    //更新会员信息
    public function membershipUpdate(Request $request){
        $data=[];

        $input= $request->except('_token');

        $validator = Validator::make($input,
            [
                'card_id' => 'required',
                'code' => 'required',
            ],
            [
                'card_id.required' => '参数card_id缺失',
                'code.required' => '参数code缺失',
            ]
        );

        if ($validator->fails()) {
            return $this->api( false, 500,$validator->errors(), '接口访问失败');
        }


        $res=CardService::membershipUpdate($input,$this->main->app_id);

        if(is_array($res)&&isset($res['errcode'])){
            return $this->api(false,$res['errcode'],$res['errmsg'],[]);
        }

        return $this->api(true,200,'',$res);
    }



}
