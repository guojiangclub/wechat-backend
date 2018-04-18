<?php

namespace iBrand\Wechat\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    use SoftDeletes;

    protected $table = 'we_replies';
    protected $guarded = ['id'];

    /**
     * 类型关注回复.
     */
    const TYPE_FOLLOW = 'follow';

    /**
     * 类型无匹配时回复.
     */
    const TYPE_NO_MATCH = 'no-match';

    /**
     * 类型关键词回复.
     */
    const TYPE_KEYWORDS = 'keywords';

    const TRIGGER_TYPE_EQUAL = 'equal';

    const TRIGGER_TYPE_CONTAIN = 'contain';

    /**
     * casts.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'json',
        'trigger_keywords' => 'json',
    ];



    /**
     * 用于表单验证时的字段名称提示.
     *
     * @var array
     */
    public static $aliases = [
        'account_id' => '所属公众号',
        'name' => '规则名称',
        'type' => '回复类型',
        'trigger_keywords' => '触发关键词',
        'trigger_type' => '触发类型',
        'group_ids' => '适用组id',
        'content' => '回复内容',
                             ];
}
