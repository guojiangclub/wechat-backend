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

/**
 * 模板服务提供类.
 */
class NoticeService
{
    protected static $appUrl;

    public function __construct()
    {
        self::$appUrl = settings('wechat_api_url');
    }

    public function getLists($app_id = null)
    {
        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/notice/get?appid='.$app_id;

        $res = wechat_platform()->wxCurl($url);

        if (isset($res->template_list) && count($res->template_list) > 0) {
            return $res->template_list;
        }

        return [];
    }

    public function show($id, $app_id = null)
    {
        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/notice/get?appid='.$app_id;

        $res = wechat_platform()->wxCurl($url);

        $data = [];

        if (isset($res->template_list) && count($res->template_list) > 0) {
            $templates = $res->template_list;
            foreach ($templates as $item) {
                if ($item->template_id === $id) {
                    $data['template_id'] = $item->template_id;
                    $data['title'] = $item->title;
                    $data['primary_industry'] = $item->primary_industry;
                    $data['deputy_industry'] = $item->deputy_industry;
                    $data['content'] = $item->content;
                    $data['example'] = $item->example;
                }
            }

            return $data;
        }

        return [];
    }

    public function sendMessage($data = [], $app_id = null)
    {
        $app_id = !empty($app_id) ? $app_id : wechat_app_id();
        $url = self::$appUrl.'api/notice/send?appid='.$app_id;

        $urlAll = self::$appUrl.'api/notice/sendall?appid='.$app_id;

        if (isset($data['touser']) && count($data['touser']) > 0) {
            $res = wechat_platform()->wxCurl($urlAll, $data);
        } else {
            $res = wechat_platform()->wxCurl($url, $data);
        }

        return $res;
    }
}
