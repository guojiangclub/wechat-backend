<?php

namespace iBrand\Wechat\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FanGroup extends Model
{
    use SoftDeletes;
    protected $table = 'we_fan_groups';
    protected $guarded = ['id'];


    /**
     * 用于表单验证时的字段名称提示.
     *
     * @var array
     */
    public static $aliases = [
        'group_id' => '粉丝组ID',
        'account_id' => '公众号ID',
        'title' => '组名称',
        'fan_count' => '粉丝数',
        'is_default' => '是否为系统默认组',
                         ];
}
