<?php

namespace iBrand\Wechat\Backend\Repository;

use App\Exceptions;
use iBrand\Wechat\Backend\Models\QRCode;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * MemberCard Repository.
 */
class QRCodeRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return QRCode::class;
    }

    public function getQRCodesPaginated($where, $limit, $order_by = 'id', $sort = 'desc')
    {
        $data= $this->scopeQuery(function ($query) use ($where) {
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
        })->with('Scna');

        if($limit>0){
            return $data->paginate($limit);
        }else{
            return $data->all();
        }
    }






}
