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

use iBrand\Wechat\Backend\Models\FanGroup;
use Prettus\Repository\Eloquent\BaseRepository;

/*
 * 微信粉丝组Repository
 *
 * 功能1： 微信线上和本地粉丝组列表
 * 功能2： 微信粉丝组管理：创建、修改、删除
 * 功能3： 微信粉丝分组设置
 *
 */

/**
 * Fans Repository.
 */
class FanGroupRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return FanGroup::class;
    }

    public function getIdBygroupid($accountId, $groupid, $insert)
    {
        /*
         * 通过openid查询
         */
        $fan = $this->model
            ->where('account_id', $accountId)
            ->where('group_id', $groupid)
            ->first();
        if ($fan) {
            $this->update($insert, $fan->id);

            return $fan;
        }
        /*
         * 若无返回结果，创建后返回
         */
        $res = $this->create($insert);

        return $res;
    }

    /**
     * 创建数据.
     *
     * @param $accountId
     * @param $input
     *
     * @return mixed
     */
    public function store($accountId, $input)
    {
        /*
         * 准备插入的数据
         */
        $_saveInfo['group_id'] = -1;
        $_saveInfo['account_id'] = $accountId;
        $_saveInfo['title'] = $input->title;
        $_saveInfo['fan_count'] = 0;
        $_saveInfo['is_default'] = 0;

        /*
         * 保存
         */
        $this->_savePost($this->model, $_saveInfo);

        /*
         * 返回生成的ID
         */
        return $this->model->id;
    }

    /**
     * update.
     *
     * @param array $input Request
     */
//    public function update($accountId, $input)
//    {
//        $model = $this->getGroupByid($accountId, $input['id']);
//
//        return $this->_savePost($model, $input);
//    }

    /**
     * Delete.
     *
     * @param int   $id    粉丝组自增ID
     * @param array $input Request
     */
//    public function delete($accountId, $id)
//    {
//
//        /*
//         * 1 查找粉丝组数据
//         */
//        $model = $this->getGroupByid($accountId, $id);
//
//        /*
//         * 2 验证这个组能不能删除
//         */
//        if ($model && !$model->is_default) {
//            /*
//             * 2.1) 本地粉丝所属组更新为"默认组"
//             */
//            $fanRepository = new FanRepository();
//            $fanRepository->moveFanGroupByGroupid($model->account_id, $model->group_id, 0);
//            /*
//             * 2.2) 软删除这个组
//             */
//            return $model->delete();
//        }
//    }

    /**
     * 使用 粉丝组自增ID 查找分组.
     *
     * @param int $id        粉丝组自增ID
     * @param int $accountId Account ID
     *
     * @return Object
     */
    public function getGroupByid($accountId, $id)
    {
        return $this->model->where('account_id', $accountId)->where('id', $id)->first();
    }

    /**
     * 使用 粉丝组group_id 查找分组.
     *
     * @param int $accountId Account ID
     * @param int $groupId   粉丝组自增ID
     *
     * @return Object
     */
    public function getGroupByGroupid($accountId, $groupId)
    {
        return $this->model->where('account_id', $accountId)->where('group_id', $groupId)->first();
    }

    /**
     * update.
     *
     * @param int   $accountId Account ID
     * @param int   $addId     加粉丝的组自增ID
     * @param array $groupIds  粉丝组group_id
     * @param array $count     数量
     */
    public function cutFanCount($accountId, $addId, $groupIds, $count)
    {
        /*
         * 增加
         */
        $addFanGroup = $this->model->find($addId);
        $_saveAddInfo['fan_count'] = $addFanGroup->fan_count + $count;
        $this->_savePost($addFanGroup, $_saveAddInfo);

        /*
         * 减掉
         */
        foreach ($groupIds as $groupId => $groupCount) {
            $cutFanGroup = $this->getGroupByGroupid($accountId, $groupId);
            $_saveCutInfo['fan_count'] = $cutFanGroup->fan_count - $groupCount;
            $this->_savePost($cutFanGroup, $_saveCutInfo);
        }
    }

    /**
     * save.
     *
     * @param object $fanGroup
     * @param array  $input    Request
     */
    private function _savePost($fanGroup, $input)
    {
        return $fanGroup->fill($input)->save();
    }
}
