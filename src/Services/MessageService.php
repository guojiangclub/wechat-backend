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

use iBrand\Wechat\Backend\Models\Event;
use iBrand\Wechat\Backend\Models\Material;

/**
 * 消息服务提供.
 */
class MessageService
{
    protected static $appUrl;
    protected static $code;

    private $event;

    private $material;

    public function __construct()
    {
        self::$appUrl = settings('wechat_api_url');
        self::$code = config('wechat-error-code');
    }

    public function CallBack($accountId, $key, $app_id = null, $open_id = null)
    {
        $data = Event::where('account_id', $accountId)->where('key', 'like', '%'.$key.'%')->with('material')->orderBy('updated_at', 'desc')->get();
        $data_new = $this->screenKeyword($data, $key);
        $return = [];
        if (count($data_new) > 0) {
            foreach ($data_new as $k => $item) {
                if ('material' == $item->type) {
                    switch ($item->material_type) {
                        case 'text':
                            $return[$k] = ['type' => 'text', 'content' => htmlspecialchars_decode(urldecode($item->material->content)), 'open_id' => $open_id, 'app_id' => $app_id];
                            break;
                        case 'image':
                            $return[$k] = ['type' => 'image', 'media_id' => $item->material->media_id, 'open_id' => $open_id, 'app_id' => $app_id];
                            break;
                        case 'video':
                            $return[$k] = ['type' => 'video', 'media_id' => $item->material->media_id, 'open_id' => $open_id, 'app_id' => $app_id, 'title' => $item->material->title, 'description' => $item->material->description];
                            break;
                        case 'article':
                            if ($article_list = Material::where('account_id', $accountId)->where('id', $item->material->id)->with('childrens')->first()) {
                                if ($article_list and count($article_list) > 0) {
                                    $return[$k]['type'] = 'article';
                                    $return[$k]['app_id'] = $app_id;
                                    $return[$k]['open_id'] = $open_id;
                                    $return[$k]['article'][0] = ['type' => 'article',
                                          'title' => $article_list->title,
                                          'description' => $article_list->description,
                                          'url' => $article_list->wechat_url,
                                          'image' => $article_list->cover_url,
                                          ];

                                    if (count($article_list->childrens) > 0) {
                                        foreach ($article_list->childrens as $key => $childrens_item) {
                                            $return[$k]['article'][$key + 1] = [
                                                  'title' => $childrens_item->title,
                                                  'description' => $childrens_item->description,
                                                  'url' => $childrens_item->wechat_url,
                                                  'image' => $childrens_item->cover_url,
                                                 ];
                                        }
                                    }
                                }
                            }
                            break;
                        default:

                            break;
                    }
                }
                if ('addon' == $item->type) {
                    $return[$k] = ['type' => 'card', 'card_id' => $item->value, 'open_id' => $open_id, 'app_id' => $app_id];
                }
            }

            if (count($return) > 0) {
                return array_values($return);
            }

            return [];
        }
    }

    public function getStaffOnLines($data = [], $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/staff/on_lines?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->kf_online_list) && count($res->kf_online_list) > 0) {
            $data = array_rand($res->kf_online_list);
            \Log::info($res->kf_online_list[$data]->kf_account);

            return $res->kf_online_list[$data]->kf_account;
        }

        return false;
    }

    public function getStaffSession($data, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/staff/session/create?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->nick_name)) {
            return $res->nick_name;
        }

        return null;
    }

    protected function screenKeyword($data, $key)
    {
        $newData = [];
        if (count($data) > 0) {
            foreach ($data as $k => $item) {
                $keyArr = explode(' ', $item->key);
                if (in_array($key, $keyArr)) {
                    $newData[] = $item;
                }
            }

            return $newData;
        }

        return [];
    }
}
