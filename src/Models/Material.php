<?php

namespace iBrand\Wechat\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model

{
    use SoftDeletes;

    protected $table = 'we_materials';
    protected $guarded = ['id'];

    /**
     * 单图文类型.
     */
    const IS_SIMPLE = 0;

    /**
     * 多图文类型.
     */
    const IS_MULTI = 1;

    /**
     * 不可编辑素材.
     */
    const CAN_NOT_EDITED = 0;

    /**
     * 可编辑素材.
     */
    const CAN_EDITED = 1;

    /**
     * 创建来自自己.
     */
    const CREATED_FROM_SELF = 0;

    /**
     * 创建来自微信
     */
    const CREATED_FROM_WECHAT = 1;


    /**
     * 用于表单验证时的字段名称提示.
     *
     * @var array
     */
    public static $aliases = [
        'account_id' => '所属公众号',
        'type' => '类型',
        'url' => '素材地址',
        'app_id' => '应用ID',
        'title' => '标题',
        'digest' => '描述',
    ];

    public function childrens()
    {
        return $this->hasMany('iBrand\Wechat\Backend\Models\Material', 'parent_id');
    }
}
