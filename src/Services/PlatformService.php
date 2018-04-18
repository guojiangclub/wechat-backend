<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-12
 * Time: 18:02
 */

namespace iBrand\Wechat\Backend\Services;

use iBrand\Wechat\Backend\Platform\Cache;
use iBrand\Wechat\Backend\Platform\AccessToken;
use iBrand\Wechat\Backend\Platform\Http;

use iBrand\Wechat\Backend\Models\Account;
use Request;



class PlatformService
{
    protected static $appUrl;

    protected static $CLIENT_ID;

    protected static $CLIENT_SECRET;

    protected static $templateMessageType = [];

    protected $token;
    protected $http;

    protected $accountRepository;


    public function __construct()
    {

        self::$appUrl = settings('wechat_api_url');
        self::$CLIENT_ID=settings('wechat_api_client_id');
        self::$CLIENT_SECRET=settings('wechat_api_client_secret');

        $this->token = new AccessToken(self::$appUrl . 'oauth/token', 'wx.api.access_token',self::$CLIENT_ID,self::$CLIENT_SECRET);

        $this->http = new Http($this->token);

    }

    public function getWechatAccounts()
    {
        $url=$_SERVER['APP_URL'];
        return $this->wxCurl(self::$appUrl . 'api/authorizers?client_id=' . self::$CLIENT_ID.'&call_back_url='.$url, null);
    }

    public function DelAccounts($app_id)
    {
        return $this->wxCurl(self::$appUrl . 'api/del?client_id=' . self::$CLIENT_ID.'&app_id='.$app_id, null);
    }



    public function getToken(){
        $Cache=new Cache('wx.api.access_token');
        $Cache->forget('wx.api.access_token');
         return $this->token->getToken();
    }


    public function getMainAccount(){
        return Account::where(['main'=>1])->first();
    }




    public function upload($type,$path,$url)
    {
        $image = curl_file_create($path);
        $data = array(
            $type => $image
        );

        $headers[] = 'Authorization:Bearer ' . $this->token->getToken();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

//        curl_setopt($ch, CURLOPT_URL, $url);
//
//        curl_setopt($ch, CURLOPT_POST, true );
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_HEADER, false);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        curl_close($ch);
        return $response;
    }

    /* 内置函数 */

    /**
     * 微信简易curl
     * @param type $url
     * @param type $optData
     * @return type
     */
    public function wxCurl($url, $optData = null)
    {

        $headers[] = 'Authorization:Bearer ' . $this->token->getToken();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if (!empty($optData)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($optData));
        }
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res);
    }

}