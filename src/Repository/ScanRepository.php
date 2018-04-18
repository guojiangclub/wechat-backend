<?php

namespace iBrand\Wechat\Backend\Repository;

use App\Exceptions;
use iBrand\Wechat\Backend\Models\Scan;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * MemberCard Repository.
 */
class ScanRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Scan::class;
    }

    public function getScansPaginated($where, $limit, $time='',$order_by = 'id', $sort = 'desc')
    {
        $data= $this->scopeQuery(function ($query) use ($where,$time,$limit) {
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
            return $query->with(['QrCode','fans'])->orderBy('updated_at', 'desc');
        });

        if($limit>0){
            return $data->paginate($limit);
        }else{
            return $data->all();
        }
    }




}
