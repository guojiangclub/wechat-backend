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

use iBrand\Wechat\Backend\Models\Account as AccountModel;
use Session;

/**
 * 公众号服务提供类.
 */
class AccountService
{
    /**
     * constructer.
     */
    public function __construct()
    {
    }

    /**
     * 当前是否有选择公众号.
     *
     * @return bool|int
     */
    public function chosedId()
    {
        return Session::get('account_id');
    }

    /**
     * 切换公众号.
     *
     * @param int $accountId 公众号的Id
     */
    public function chose($accountId)
    {
        return Session::put('account_id', $accountId);
    }

    /**
     * 创建识别tag.
     *
     * @return string tag
     */
    public function buildTag()
    {
        return str_random(15);
    }

    /**
     * 创建token.
     *
     * @return string token
     */
    public function buildToken()
    {
        return str_random(10);
    }

    /**
     * 创建aesKey.
     *
     * @return string aesKey
     */
    public function buildAesKey()
    {
        return str_random(43);
    }

    /**
     * 获取当前选择的Account.
     *
     * @return Account
     */
    public function current()
    {
        return AccountModel::where('app_id', Session::get('account_app_id'))->first();
    }

    public function getAppIdByAccountID($id)
    {
        return AccountModel::where('id', $id)->pluck('app_id')->first();
    }
}
