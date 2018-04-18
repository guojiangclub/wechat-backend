<?php
namespace iBrand\Wechat\Backend\Repository;

use iBrand\Wechat\Backend\Models\FanReport;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Fans Repository.
 */
class FanReportRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FanReport::class;
    }

    /**
     * store.
     *
     * @param array $input
     */
    public function store($input)
    {

        /*
         * 准备插入的数据
         */
        $_saveInfo['account_id'] = $input['account_id'];
        $_saveInfo['openid'] = $input['openid'];
        $_saveInfo['type'] = $input['type'];

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
     * save.
     *
     * @param object $fanReport
     * @param array  $input     Request
     */
    private function _savePost($fanReport, $input)
    {
        return $fanReport->fill($input)->save();
    }
}
