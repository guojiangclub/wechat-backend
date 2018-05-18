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

use Auth;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
//use iBrand\Component\User\Models\User;
//use iBrand\Component\User\Models\UserBind;
use Overtrue\Socialite\SocialiteManager;

class WechatSocialiteController extends Controller
{
    protected static $config;

    protected static $socialite;

    public function __construct()
    {
        self::$config = [
            'wechat' => [
                'client_id' => 'wxad472334dfb49e42',
                'client_secret' => 'eb83ae671fc663b7ebbe0dfdc7943986',
                'redirect' => route('pc.auth.wecaht.callback'),
            ],
        ];
        self::$socialite = new SocialiteManager(self::$config);
    }

    public function wechatAuthorize()
    {
        $response = self::$socialite->driver('wechat')->redirect();

        return $response;
    }

    public function wechatCallback()
    {
        try {
            $user = self::$socialite->driver('wechat')->user();
        } catch (\Exception $e) {
            $response = self::$socialite->driver('wechat')->redirect();

            return $response;
        }
        $original = $user->original;

        $openid = $original['openid'];

        return $this->UserBind($openid, 'wechat');
    }

    protected function UserBind($openId, $type)
    {
        $userBind = UserBind::byOpenIdAndType($openId, $type)->first();

        if ($userBind and $userBind->user_id and $user = User::find($userBind->user_id)) {
            Auth::loginUsingId($userBind->user_id, true);

            return redirect()->route('pc.store.index');
        }

        if (empty($userBind)) {
            $userBind = UserBind::create(['open_id' => $openId, 'type' => $type]);
        }

        if (empty($userBind->user_id)) {
            $bind_id = $userBind->id;

            return Admin::content(function (Content $content) use ($bind_id) {
                $content->body(view('store-frontend::login.index', compact('bind_id')));
            });
        }
    }
}
