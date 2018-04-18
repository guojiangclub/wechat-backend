<?php
namespace iBrand\Wechat\Backend\Services;

use iBrand\Wechat\Backend\Models\Card;
use iBrand\Wechat\Backend\Repository\CardRepository;

/**
 * 卡券优惠券服务提供类.

 */
class CouponService
{

    protected static $appUrl;
    protected static $code;

    public function __construct()
    {
        self::$appUrl = settings('wechat_api_url');
        self::$code=config('wechat-error-code');

    }
    

    // 创建卡券
    public function create($data,$app_id=null){

        $return=[];

        $app_id=empty($app_id)?wechat_app_id():$app_id;

        $url = self::$appUrl . "api/coupon/create?appid=" . $app_id;

        $code=self::$code;

        $res=wechat_platform()->wxCurl($url,$data);

        if(isset($res->errcode)&&$res->errcode!==0){
            $return['errcode']=$res->errcode;
            $return['errmsg']=isset($code[$res->errcode])?$code[$res->errcode]:$res->errmsg;
        }

        if(isset($res->errmsg) && $res->errmsg === 'ok')
        {
            return $res;
        }

        return $return;

    }
 
    //  更新卡券信息
    public function  update($data,$app_id=null){

        $return=[];

        $app_id=empty($app_id)?wechat_app_id():$app_id;

        $url = self::$appUrl . "/api/coupon/update?appid=" . $app_id;

        $code=self::$code;

        $res=wechat_platform()->wxCurl($url,$data);

        if(isset($res->errcode)&&$res->errcode!==0){
            $return['errcode']=$res->errcode;
            $return['errmsg']=isset($code[$res->errcode])?$code[$res->errcode]:$res->errmsg;
        }

        if(isset($res->errmsg) && $res->errmsg === 'ok')
        {
            return $res;
        }

        return $return;

    }


    // 卡券颜色
    public function cardColors($app_id=null){

        $return=[];

        $app_id=empty($app_id)?wechat_app_id():$app_id;

        $url = self::$appUrl . "api/coupon/colors?appid=" . $app_id;

        $code=self::$code;

        $res=wechat_platform()->wxCurl($url);

        if(isset($res->errcode)&&$res->errcode!==0){
            $return['errcode']=$res->errcode;
            $return['errmsg']=isset($code[$res->errcode])?$code[$res->errcode]:$res->errmsg;
        }

        if(isset($res->errmsg) && $res->errmsg === 'ok')
        {
            return $res;
        }

        return $return;

    }

    //获取卡券信息
    public function getCardInfo($data,$app_id=null){

        $return=[];

        $app_id=empty($app_id)?wechat_app_id():$app_id;

        $url = self::$appUrl . "api/coupon/getinfo?appid=".$app_id;

        $code=self::$code;

        $res=wechat_platform()->wxCurl($url,$data);

        if(isset($res->errcode)&&$res->errcode!==0){
            $return['errcode']=$res->errcode;
            $return['errmsg']=isset($code[$res->errcode])?$code[$res->errcode]:$res->errmsg;
        }

        if(isset($res->errmsg) && $res->errmsg === 'ok')
        {
            return $res;
        }

        return $return;

    }

    // 卡券生成二维码
    public function getCardQRCode($data,$app_id=null){

        $return=[];

        $app_id=empty($app_id)?wechat_app_id():$app_id;

        $url = self::$appUrl . "api/coupon/QRCode?appid=".$app_id;

        $code=self::$code;

        $res=wechat_platform()->wxCurl($url,$data);

        if(isset($res->errcode)&&$res->errcode!==0){
            $return['errcode']=$res->errcode;
            $return['errmsg']=isset($code[$res->errcode])?$code[$res->errcode]:$res->errmsg;
        }

        if(isset($res->errmsg) && $res->errmsg === 'ok')
        {
            return $res;
        }

        return $return;

    }

    // 查询Code接口
    public function getCode($data,$app_id=null){

        $return=[];

        $app_id=empty($app_id)?wechat_app_id():$app_id;

        $url = self::$appUrl . "api/coupon/getcode?appid=".$app_id;

        $code=self::$code;

        $res=wechat_platform()->wxCurl($url,$data);

        if(isset($res->errmsg)&&!empty($res->errmsg!=="ok")){
            $return['errcode']=500;
            $return['errmsg']=$res->errmsg;
        }else{
            return $res;
        }

        return $return;

    }


    // 核销Code接口
    public function consumeCode($data,$app_id=null){

        $return=[];

        $app_id=empty($app_id)?wechat_app_id():$app_id;

        $url = self::$appUrl . "api/coupon/consumeCode?appid=".$app_id;

        $code=self::$code;

        $res=wechat_platform()->wxCurl($url,$data);

        if(isset($res->errmsg)&&!empty($res->errmsg!=="ok")){
            $return['errcode']=500;
            $return['errmsg']=$res->errmsg;
        }else{
            return $res;
        }

        return $return;

    }



    //更新卡券库存
    public function updateQuantity($data,$app_id=null){
        $return=[];

        $app_id=empty($app_id)?wechat_app_id():$app_id;

        $url = self::$appUrl . "api/coupon/update/quantityt?appid=".$app_id;

        $code=self::$code;

        $res=wechat_platform()->wxCurl($url,$data);

        if(isset($res->errcode)&&$res->errcode!==0){
            $return['errcode']=$res->errcode;
            $return['errmsg']=isset($code[$res->errcode])?$code[$res->errcode]:$res->errmsg;
        }

        if(isset($res->errmsg) && $res->errmsg === 'ok')
        {
            return $res;
        }

        return $return;
    }


    //删除卡券
    public function deleteCard($data,$app_id=null){
        $return=[];

        $app_id=empty($app_id)?wechat_app_id():$app_id;

        $url = self::$appUrl . "api/coupon/delete?appid=".$app_id;

        $code=self::$code;

        $res=wechat_platform()->wxCurl($url,$data);


        if(isset($res->errcode)&&$res->errcode!==0){
            $return['errcode']=$res->errcode;
            $return['errmsg']=isset($code[$res->errcode])?$code[$res->errcode]:$res->errmsg;
        }

        if(isset($res->errmsg) && $res->errmsg === 'ok')
        {
            return $res;
        }

        return $return;
    }

    //指定卡券失效
    public function disableCard($data,$app_id=null){
        $return=[];

        $app_id=empty($app_id)?wechat_app_id():$app_id;

        $url = self::$appUrl . "api/coupon/disable?appid=".$app_id;

        $code=self::$code;

        $res=wechat_platform()->wxCurl($url,$data);


        if(isset($res->errcode)&&$res->errcode!==0){
            $return['errcode']=$res->errcode;
            $return['errmsg']=isset($code[$res->errcode])?$code[$res->errcode]:$res->errmsg;
        }

        if(isset($res->errmsg) && $res->errmsg === 'ok')
        {
            return $res;
        }

        return $return;
    }














}
