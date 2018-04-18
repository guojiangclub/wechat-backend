<?php

namespace iBrand\Wechat\Backend\Services;
use Log;

class FanService
{

    protected static $appUrl;

    protected $fanRepository;

    public function __construct()
    {
        self::$appUrl = settings('wechat_api_url');

    }

    /**
     * 从微信数据格式化.
     *
     * @param array $fan
     *
     * @return array
     */
    public function formatFromWeChat($fan)
    {
        return [
            'openid' => $fan['openid'],
            'nickname' => urlencode($fan['nickname']),               //昵称
            'sex' => $fan['sex']==1 ? '男' : '女',                         //性别
            'city' => $fan['city'],                       //城市
            'country' => $fan['country'],                 //国家
            'province' => $fan['province'],               //省
            'language' => $fan['language'],               //语言
            'avatar' => $fan['headimgurl'],               //头像
            'subscribed_at' => date('Y-m-d H:i:s', $fan['subscribe_time']), //关注时间
            'unionid' => array_get($fan, 'unionid'),                 //unionid
            'remark' => $fan['remark'],                   //备注
            'group_id' => $fan['groupid'] ? $fan['groupid'] : 0, //组ID
            'tagid_list' => json_encode($fan['tagid_list']),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => null,
        ];
    }

    public function getLists($nextOpenId='',$app_id=null){
        $ret=[];

        $app_id=empty($app_id)?wechat_app_id():$app_id;

        $url = self::$appUrl . "api/fans/lists?appid=" . $app_id."&nextOpenId=$nextOpenId";

        $res=wechat_platform()->wxCurl($url);

        if(isset($res->data->openid) && count($res->data->openid)>0)
        {
                return  $res;

//               return $this->getFansInfo($res->data->openid);
//                $resfans=$this->getFansInfo($res->data->openid);
//
//                foreach ($resfans->user_info_list as $k=>$item){
//                    $ret['info'][$k]=$this->formatFromWeChat(collect($item)->toArray());
//                }

        }
        return $ret;
    }



//获取粉丝
    public function getFansInfo($openid=[],$app_id=null){

        $app_id=empty($app_id)?wechat_app_id():$app_id;

        if(is_array($openid)&&count($openid)>0){

            $url = self::$appUrl . "api/fans/get?appid=" . $app_id;

            $data['openid'] = $openid;

            $res=wechat_platform()->wxCurl($url,$data);

            if(isset($res->user_info_list)&&count($res->user_info_list)>0){
                return $res;
            }
        }
        return $openid;
    }




//    获取用户组
    public function FansGroupList($app_id=null){

        $app_id=empty($app_id)?wechat_app_id():$app_id;

        $url = self::$appUrl . "api/fans/group/lists?appid=" .$app_id;

        $res=wechat_platform()->wxCurl($url);

        if(isset($res->tags)&&count($res->tags)>0){
            return $res->tags;
        }
        return [];
    }


//    添加用户组

    public function createFansGroup($name,$app_id=null){

        $app_id=empty($app_id)?wechat_app_id():$app_id;

        $url = self::$appUrl . "api/fans/group/create?appid=" . $app_id;

        $data['name']=$name;

        $res=wechat_platform()->wxCurl($url,$data);

        if(isset($res->tag)&&count($res->tag)>0){
            return $res->tag;
        }
        return [];
    }

//    删除用户组
    public function delFansGroup($id,$app_id=null){
        $app_id=empty($app_id)?wechat_app_id():$app_id;
        $url = self::$appUrl . "api/fans/group/delete?appid=" . $app_id;
        $data['groupid']=$id;
        $res=wechat_platform()->wxCurl($url,$data);
        if(isset($res->errmsg)&&$res->errmsg==="ok"){
            return true;
        }
        return false;
    }


    //    删除用户标签
    public function delFansTag($data,$app_id=null){
        $app_id=empty($app_id)?wechat_app_id():$app_id;
        $url = self::$appUrl . "api/fans/group/delUsers?appid=" . $app_id;
        $res=wechat_platform()->wxCurl($url,$data);
        if(isset($res->errmsg)&&$res->errmsg==="ok"){
            return true;
        }
        return false;
    }



//    编辑用户组
    public function editFansGroup($data,$app_id=null){
        $app_id=empty($app_id)?wechat_app_id():$app_id;
        $url = self::$appUrl . "api/fans/group/update?appid=" . $app_id;
        $res=wechat_platform()->wxCurl($url,$data);
        if(isset($res->errmsg)&&$res->errmsg==="ok"){
            return true;
        }
        return false;
    }



    public function moveUsers($data,$app_id=null){
        $app_id=empty($app_id)?wechat_app_id():$app_id;
        $url = self::$appUrl . "api/fans/group/addUsers?appid=" . $app_id;
        $res=wechat_platform()->wxCurl($url,$data);
        if(isset($res->errmsg)&&$res->errmsg==="ok"){
            return true;
        }
        return false;
    }




}
