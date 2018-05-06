<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Repository;

use iBrand\Wechat\Backend\Facades\AccountService;
use iBrand\Wechat\Backend\Models\Account;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;
use Session;

/**
 * Account Repository.
 */
class AccountRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Account::class;
    }

    public function __construct()
    {
        parent::__construct(new Application());
    }

    /**
     *创建微信公众号.
     *
     * @param $input
     *
     * @return mixed
     */
    public function createAccount($input)
    {
        return $this->create([
            'name' => $input['name'],
            'original_id' => $input['original_id'],
            'wechat_account' => $input['wechat_account'],
            'app_id' => $input['app_id'],
            'app_secret' => $input['app_secret'],
            'account_type' => $input['account_type'],
            'tag' => AccountService::buildTag(),
            'token' => AccountService::buildToken(),
            'aes_key' => AccountService::buildAesKey(),
        ]);
    }

    /**
     * 获取公众号列表.
     *
     * @param $where
     * @param int    $limit
     * @param string $order_by
     * @param string $sort
     *
     * @return mixed
     */
    public function getAccountPaginated($where, $limit = 50, $order_by = 'id', $sort = 'desc')
    {
        return $this->scopeQuery(function ($query) use ($where) {
            if (is_array($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        list($operate, $va) = $value;
                        $query = $query->where($key, $operate, $va);
                    } else {
                        $query = $query->where($key, $value);
                    }
                }
            }

            return $query->orderBy('updated_at', 'desc');
        })->paginate($limit);
    }

    /**
     *通过ID获取公众号.
     *
     * @param $id
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function findOrThrowException($id)
    {
        $account = $this->findByField('id', $id)->first();
        if (!is_null($account)) {
            return $account;
        }
        throw new Exception('The account does not exist');
    }

    /**
     * 根据tag获取公众号.
     *
     * @param $tag
     *
     * @return mixed
     */
    public function getAccountByTag($tag)
    {
        return $this->findByField('tag', $tag)->first();
    }

    /**
     * 切换公众号.
     *
     * @param int $id id
     */
    public function changeById($id)
    {
        Session::put('account_id', $id);
    }

    /**
     * 删除公众号.
     *
     * @param $id
     *
     * @return int
     */
    public function destroy($id)
    {
        $account = $this->findOrThrowException($id);

        return $this->delete($id);
    }

//    public  function get(){
//
//        return $this->model();
//    }

    public function createAccountByAppID($data)
    {
        $appIDs = [];
        if (count($data) > 0) {
            foreach ($data as $key => $item) {
                $main = 0;
                if ($item->appid == settings('wechat_app_id')) {
                    $main = 1;
                }
                if ($account = $this->findByField(['app_id' => $item->appid])->first()) {
                    if (empty($account->name) || empty($account->account_type)) {
                        $this->update(
                            ['name' => isset($item->nick_name) ? $item->nick_name : '', 'original_id' => isset($item->user_name) ? $item->user_name : '',
                            'account_type' => isset($item->service_type_info) ? $item->service_type_info : 2,
                             'verify_type_info' => isset($item->verify_type_info) ? $item->verify_type_info : 0,
                           'main' => $main, ], $account->id);
                    }
                } else {
                    $this->create(
                        ['app_id' => isset($item->appid) ? $item->appid : '',
                            'main' => $main,
                            'name' => isset($item->nick_name) ? $item->nick_name : '',
                            'original_id' => isset($item->user_name) ? $item->user_name : '',
                            'verify_type_info' => isset($item->verify_type_info) ? $item->verify_type_info : 0,
                            'account_type' => isset($item->service_type_info) ? $item->service_type_info : 2, ]);
                }

                $appIDs[$key] = $item->appid;
            }
        }

        return $this->findWhereIn('app_id', $appIDs);
    }

    // 获取主账号
    public function getAccountMain()
    {
        return $this->findByField('main', 1)->first();
    }

    public function updateAccount($data, $id)
    {
        if (count($data > 0)) {
            $app_id = Account::find($id)->app_id;

            $main = $this->getAccountMain();

            if (!$main and 1 == $data['main']) {
                settings()->setSetting(['wechat_app_id' => $app_id]);
            }
            if ($main and 1 == $data['main'] and $main->id != $id) {
                settings()->setSetting(['wechat_app_id' => $app_id]);
                $this->update(['main' => 0], $main->id);
            }

            if (0 == $data['main'] and $main and $main->id == $id) {
                settings()->setSetting(['wechat_app_id' => '']);
            }

            return $this->update($data, $id);
        }

        return false;
    }
}
