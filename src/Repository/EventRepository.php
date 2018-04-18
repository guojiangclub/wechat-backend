<?php

namespace iBrand\Wechat\Backend\Repository;


use Prettus\Repository\Eloquent\BaseRepository;
use iBrand\Wechat\Backend\Facades\AccountService;
use iBrand\Wechat\Backend\Models\Event;


/**
 * Event Repository.
 */
class EventRepository extends BaseRepository
{


    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Event::class;
    }


    public function getEventsPaginated($where, $limit, $order_by = 'id', $sort = 'desc')
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
        })->with('material');

        if($limit>0){
            return $data->paginate($limit);
        }else{
            return $data->all();
        }
    }



    /**
     *
     *
     * @param string $eventKey eventKey
     *
     * @return Event event
     */
    public function getEventByKey($eventId)
    {
       return $this->findByField('key',$eventId)->first();
    }

    /**
     * 通过key删除事件.
     *
     * @param string $eventKey $eventKey
     */
    public function distoryByEventKey($eventKey)
    {
        return $this->model->where('key', $eventKey)->delete();
    }

    /**
     * 存储一个文字回复类型事件.
     * 
     * @param int    $accountId 公众号id
     * @param string $text      回复内容
     *
     * @return string key
     */
    public function storeTextEvent($accountId, $text)
    {
        $key=$this->getEventByKey();
        return $this->create([
            'account_id' =>$accountId,
            'key'=>$key,
           'value'=>$text,
            'type'=>'material',
        ]);
    }

    /**
     * 更新事件
     *
     * @param string $eventId   事件ID
     * @param string $text      文字回复内容
     */
    public function updateEvent($eventId, $text)
    {
        $date['value']=$text;
        $date['type']='material';
       return $this->update($date,$eventId);
    }


    /**
     * 是否属于自己的事件.
     *
     * @param string $name name
     *
     * @return bool
     */
    public function isOwnEvent($name)
    {
        return starts_with($name, 'V_EVENT_');
    }

    /**
     * 创建key名称.
     *
     * @return string
     */
    public function makeEventKey()
    {
        return 'V_EVENT_'.strtoupper(uniqid());
    }

}
