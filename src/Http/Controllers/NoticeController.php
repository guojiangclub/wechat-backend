<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Http\Controllers;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use iBrand\Wechat\Backend\Facades\NoticeService;
use Illuminate\Http\Request;

/**
 * 模板消息管理.
 */
class NoticeController extends Controller
{
    public function __construct()
    {
    }

    /**
     * 列表.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $notices = NoticeService::getLists();

        return Admin::content(function (Content $content) use ($notices) {
            $content->description('我的模板');

            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '模板消息', 'url' => 'wechat/notice','no-pjax'=>1],
                ['text' => '我的模板', 'url' => 'wechat/notice','no-pjax'=>1,'left-menu-active' => '我的模板']
            );
            $content->body(view('Wechat::notice.index', compact('notices')));
        });
    }

    /**
     *详情.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $notice = NoticeService::show($id);

        return Admin::content(function (Content $content) use ($notice) {
            $content->description('模板详情');

            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '模板消息', 'url' => 'wechat/notice','no-pjax'=>1],
                ['text' => '我的模板', 'url' => 'wechat/notice','no-pjax'=>1],
                ['text' => '模板详情','left-menu-active' => '我的模板']
            );

            $content->body(view('Wechat::notice.show', compact('notice','menu')));
        });
    }

    /**
     *编辑模板发送
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendOutEdit($id)
    {
        $notice = NoticeService::show($id);
        $name = $this->formatDataGetName($notice['content']);

        return Admin::content(function (Content $content) use ($id, $name, $notice) {
            $content->description('发送模板');

            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '模板消息', 'url' => 'wechat/notice','no-pjax'=>1],
                ['text' => '我的模板', 'url' => 'wechat/notice','no-pjax'=>1],
                ['text' => '发送模板','left-menu-active' => '我的模板']
            );

            $content->body(view('Wechat::notice.sendout', compact('notice', 'name', 'id')));
        });
    }

    /**
     *模板发送
     */
    public function sendOut(Request $request)
    {
        $data = $request->except('_token');

//        $appid=isset($data['appid'])?$data['appid']:'';

        $appid = wechat_app_id();

        $notice = NoticeService::sendMessage($data, $appid);

        if (0 !== $notice->success_num) {
            return $this->api(true, 200, '', []);
        }

        return $this->api(false, 400, '', ['error' => $notice->error]);
    }

    private function formatDataGetName($str)
    {
        $result = [];
        preg_match_all("/(?:\{{)(.*)(?:.DATA\}})/i", $str, $result);
        $msg = [];
        $data = [];
        $newData = [];
        if (count($result[1]) > 0) {
            foreach ($result[1] as $item) {
                if (strstr($item, '.DATA}}') || strstr($item, '{{')) {
                    $msg[] = preg_replace('/.DATA}}.+{{/is', '###', $item);
                } else {
                    $newData[] = $item;
                }
            }
            if (count($msg) > 0) {
                foreach ($msg as $item) {
                    $data[] = explode('###', $item);
                }
            }
        }

        return array_merge(array_values(array_dot($data)), $newData);
    }
}
