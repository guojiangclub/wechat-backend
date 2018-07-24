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

use iBrand\Wechat\Backend\Models\Scan;
use Prettus\Repository\Eloquent\BaseRepository;
use Carbon\Carbon;

/**
 * MemberCard Repository.
 */
class ScanRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Scan::class;
    }

    public function getScansPaginated($where, $limit, $time = '', $order_by = 'id', $sort = 'desc')
    {
        $data = $this->scopeQuery(function ($query) use ($where,$time,$limit) {
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

            return $query->with(['QrCode', 'fans'])->orderBy('updated_at', 'desc');
        });

        if ($limit > 0) {
            return $data->paginate($limit);
        }

        return $data->all();
    }



    /**
     * N天扫码数
     */
    public function getScanCountDayByAppID($app_id, $day)
    {
        $today = Carbon::today()->timestamp;
        $tomorrow = Carbon::tomorrow()->timestamp;
        $day_jian=$day+1;

        return $this->model->where('app_id', $app_id)
            ->where('created_at', '>=', date('Y-m-d', strtotime("$day day", $today)))
            ->where('created_at', '<', date('Y-m-d', strtotime("$day_jian day", $today)))
            ->count();
    }

    /**
     * 格式化导出数据.
     *
     * @param $data
     *
     * @return array
     */

    public function formatToExcelData($data){
        $list = [];
        if (count($data) > 0) {
            $i = 0;
            foreach ($data as $item) {
                $list[$i][] = isset($item->fans->nickname)?urldecode($item->fans->nickname):'';
                $list[$i][] = $item->type==1?"关注":"扫描";
                $list[$i][] = $item->created_at;
                $list[$i][] = $item->name;
                $list[$i][] = (isset($item->QrCode->type) AND $item->QrCode->type==2)?'永久二维码':'临时二维码';
                ++$i;
            }
        }

        return $list;
    }
    


}
