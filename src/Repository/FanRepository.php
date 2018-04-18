<?php

namespace iBrand\Wechat\Backend\Repository;

use iBrand\Wechat\Backend\Models\Fan;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Fans Repository.
 */
class FanRepository  extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Fan::class;
    }


    /**
     * 获取粉丝列表
     * @param $where
     * @param int $limit
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getFansPaginated($where, $limit = 50, $time=[],$order_by = 'subscribed_at', $sort = 'desc')
    {
        return $this->scopeQuery(function ($query) use ($where,$order_by,$sort,$time) {
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

            if (is_array($time)) {
                foreach ($time as $key => $value) {
                    if (is_array($value)) {
                        list($operate, $va) = $value;
                        $query = $query->where($key, $operate, $va);
                    } else {
                        $query = $query->where($key, $value);
                    }
                }
            }
            return $query->orderBy($order_by,$sort);
        })->paginate($limit);
    }


    /**
     * 通过openid获取fans的id，无数据时创建后返回.
     *
     * @param int $accountId 账户ID
     * @param int $openId    Open ID
     *
     * @return int fansID
     */
    public function getIdByOpenid($accountId, $openId,$insert)
    {
        /*
         * 通过openid查询
         */
        $fan = $this->model
                ->where('account_id', $accountId)
                ->where('openid', $openId)
                ->first();
        if ($fan) {
            return $fan->id;
        } else {
            /*
             * 若无返回结果，创建后返回
             */
            return $this->create($insert);
        }
    }

    /**
     * 粉丝活跃度+1.
     */
    public function updateLiveness($request)
    {
        $model = $this->model
                ->where('account_id', $request['account_id'])
                ->where('openid', $request['openid'])
                ->first();
        if ($model) {
            $liveness = $model->liveness + 1;
        }

        return $this->_savePost($model, ['liveness' => $liveness]);
    }

    /**
     * 修改粉丝信息.
     */
    public function updateRemark($request)
    {
        $model = $this->model->find($request['id']);

        return $this->_savePost($model, ['remark' => $request['remark']]);
    }

    /**
     * 通过粉丝ID 更改粉丝所属组(支持批量).
     *
     * @param Array $ids       粉丝自增ID
     * @param Int   $toGroupId 粉丝组group_id
     */
    public function moveFanGroupByFansid($ids, $toGroupId)
    {
        foreach ($ids as $id) {
            $model = $this->model->find($id);
            $this->_savePost($model, ['group_id' => $toGroupId]);
        }

        return true;
    }

    /**
     * 通过粉丝ID 获取粉丝组group_id和粉丝人数[支持批量].
     *
     * @param Array $ids 粉丝自增ID
     */
    public function getFanGroupByfanIds($ids)
    {
        $groupIds = [];
        $return = [];
        //根据粉丝ID查询group_id
        $fans = $this->model->find($ids);
        if ($fans) {
            foreach ($fans as $fan) {
                $groupIds[$fan['id']] = $fan['group_id'] ? $fan['group_id'] : 0;
            }

            foreach ($groupIds as $groupId) {
                $return[$groupId] = isset($return[$groupId]) ? ($return[$groupId] + 1) : 1;
            }
        }

        return $return;
    }

    /**
     * 通过粉丝组ID 更改粉丝所属组(支持批量).
     *
     * @param Array $ids       粉丝自增ID
     * @param Int   $toGroupId 粉丝组group_id
     */
    public function moveFanGroupByGroupid($accountId, $fromGroupId, $toGroupId)
    {

        //根据粉丝ID查询
        return $this->model->where('account_id', $accountId)
                    ->where('group_id', $fromGroupId)
                    ->update(['group_id' => $toGroupId]);
    }

    /**
     * save.
     *
     * @param object $fan
     * @param array  $input Request
     */
    private function _savePost($fan, $input)
    {
        return $fan->fill($input)->save();
    }




    public function getFansByOpenid($accountId, $openId,$insert)
    {
        $fan = $this->model
            ->where('account_id', $accountId)
            ->where('openid', $openId)
            ->first();
        if ($fan) {
           return $this->update($insert,$fan->id);
        } else {
            return $this->create($insert);
        }
    }






}
