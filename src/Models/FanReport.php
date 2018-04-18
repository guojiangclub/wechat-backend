<?php

namespace iBrand\Wechat\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FanReport extends Model
{
    use SoftDeletes;

    protected $table = 'we_fan_reports';
    protected $guarded = ['id'];

    /**
     * 用于表单验证时的字段名称提示.
     *
     * @var array
     */
    public static $aliases = [
        'account_id' => '公众号ID',
        'openid' => 'OPENID',
        'type' => '操作类型',
                         ];
}
