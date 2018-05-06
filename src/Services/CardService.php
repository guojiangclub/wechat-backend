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

use iBrand\Wechat\Backend\Models\Card;

/**
 * 会员卡服务提供类.
 */
class CardService
{
    protected static $appUrl;
    protected static $code;

    public function __construct()
    {
        self::$appUrl = settings('wechat_api_url');
        self::$code = config('wechat-error-code');
    }

//    创建会员卡
    public function createCard($data, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/card/create?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;
        }

        if (isset($res->errmsg) && 'ok' === $res->errmsg) {
            return $res;
        }

        return $return;
    }

    //    编辑更新会员卡信息
    public function updateCard($data, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/card/update/member_card?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;
        }

        if (isset($res->errmsg) && 'ok' === $res->errmsg) {
            return $res;
        }

        return $return;
    }

//    卡券颜色
    public function cardColors($app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/card/colors?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;
        }

        if (isset($res->errmsg) && 'ok' === $res->errmsg) {
            return $res;
        }

        return $return;
    }

    //    获取会员卡信息
    public function getCardInfo($data, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/card/getinfo?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;
        }

        if (isset($res->errmsg) && 'ok' === $res->errmsg) {
            return $res;
        }

        return $return;
    }

    // 会员卡生成二维码
    public function getCardQRCode($data, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/card/QRCode?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;
        }

        if (isset($res->errmsg) && 'ok' === $res->errmsg) {
            return $res;
        }

        return $return;
    }

    // 获取会员卡code
    public function getCode($data, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/card/getcode?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->errmsg) && !empty($res->errmsg)) {
            $return['errcode'] = 500;
            $return['errmsg'] = $res->errmsg;
        } else {
            return $res;
        }

        return $return;
    }

    //会员卡激活
    public function membershipActivate($data, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/card/membership/activate?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;
        }

        if (isset($res->errmsg) && 'ok' === $res->errmsg) {
            return $res;
        }

        return $return;
    }

    //获取会员信息
    public function membershipGet($data, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/card/membership/get?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;
        }

        if (isset($res->errmsg) && 'ok' === $res->errmsg) {
            return $res;
        }

        return $return;
    }

    //更新会员卡库存
    public function updateQuantity($data, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/card/update/quantityt?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;
        }

        if (isset($res->errmsg) && 'ok' === $res->errmsg) {
            return $res;
        }

        return $return;
    }

    //删除会员卡
    public function deleteCard($data, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/card/delete?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;
        }

        if (isset($res->errmsg) && 'ok' === $res->errmsg) {
            return $res;
        }

        return $return;
    }

    //指定会员卡失效
    public function disableCard($data, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/card/disable?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;
        }

        if (isset($res->errmsg) && 'ok' === $res->errmsg) {
            return $res;
        }

        return $return;
    }

    //更新会员信息
    public function membershipUpdate($data, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/card/membership/update?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;
        }

        if (isset($res->errmsg) && 'ok' === $res->errmsg) {
            return $res;
        }

        return $return;
    }
}
