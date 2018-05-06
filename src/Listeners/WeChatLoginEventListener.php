<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Listeners;

use DB;
use iBrand\Component\User\Repositories\UserBindRepository;
use iBrand\Component\User\Repositories\UserRepository;
use iBrand\Wechat\Backend\Facades\NoticeService;
use Redis;

class WeChatLoginEventListener
{
    protected $user;
    protected $userBind;

    public function __construct(UserRepository $userRepository, UserBindRepository $userBindRepository)
    {
        $this->user = $userRepository;
        $this->userBind = $userBindRepository;
    }

    public function login(array $params, $event_type, $user_info)
    {
        if (!isset($params['app_id']) || !isset($params['openid'])) {
            return;
        }

        if ('subscribe' == $event_type && isset($user_info->user_info_list) && count($user_info->user_info_list) > 0) {
            $user = $user_info->user_info_list[0];
            $user = collect($user)->toArray();
            $data = [
                'app_id' => $params['app_id'],
                'subscribe' => $user['subscribe'],
                'openid' => $user['openid'],
                'nick_name' => $user['nickname'],
                'sex' => $user['sex'],
                'city' => $user['city'],
                'province' => $user['province'],
                'country' => $user['country'],
                'language' => $user['language'],
                'headimgurl' => $user['headimgurl'],
                'subscribe_time' => $user['subscribe_time'],
                'unionid' => $user['unionid'],
                'remark' => $user['remark'],
                'groupid' => $user['groupid'],
                'tagid_list' => json_encode($user['tagid_list']),
                'subscribe_scene' => $user['subscribe_scene'],
                'qr_scene' => $user['qr_scene'],
                'qr_scene_str' => $user['qr_scene_str'],
            ];

            try {
                DB::beginTransaction();
                $checkUserExists = $this->user->findWhere(['openid' => $user['openid']])->first();
                if (!$checkUserExists) {
                    $data['password'] = bcrypt(123456);
                    $res = $this->user->create($data);
                    $this->userBind->create([
                        'type' => 'wechat',
                        'app_id' => $params['app_id'],
                        'open_id' => $user['openid'],
                        'user_id' => $res->id,
                    ]);
                } else {
                    $this->user->update($data, $checkUserExists->id);
                }

                DB::commit();
            } catch (\Exception $exception) {
                \Log::info($exception->getMessage());
                \Log::info($exception->getTraceAsString());
                DB::rollBack();

                return;
            }
        }

        $template_id = app('system_setting')->getSetting('wechat_login_code');
        $code = $this->generateCode();
        Redis::set($code, $code.'_'.$params['openid']);
        $data = [
            'template_id' => $template_id,
            'url' => '',
            'touser' => [$params['openid']],
            'data' => [
                'first' => '您收到一条iBrand官网登陆验证码：',
                'keyword1' => $code,
                'keyword2' => date('Y-m-d H:i:s'),
                'remark' => '5分钟内有效，请勿泄露！',
            ],
        ];

        NoticeService::sendMessage($data, $params['app_id']);
    }

    /**
     * @return string
     */
    public function generateCode()
    {
        $length = app('system_setting')->getSetting('wechat_login_code_length');
        $length = $length ? $length : 5;
        $characters = '0123456789';
        $charLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[mt_rand(0, $charLength - 1)];
        }

        return $randomString;
    }

    public function subscribe($events)
    {
        $events->listen(
            'ibrandcc.wechat.login',
            'iBrand\Wechat\Backend\Listeners\WeChatLoginEventListener@login'
        );
    }
}
