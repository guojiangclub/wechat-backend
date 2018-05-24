<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Services;


class DataService
{
    protected static $appUrl;

    protected static $code;

    public function __construct(
    ) {
        self::$appUrl = settings('wechat_api_url');

        self::$code = config('ibrand.wechat-error-code');
    }


    public function dataCube($form,$to,$str, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/data/'.$str.'?appid='.$app_id.'&form='.$form.'&to='.$to;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url);


        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;
        }

        if (isset($res->list) && !empty($res->list)) {
            return $res;
        }

        return $return;
    }
    

    


}
