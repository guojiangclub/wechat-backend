<?php

namespace iBrand\Wechat\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Prettus\Repository\Traits\TransformableTrait;

class CardCode extends Model
{
    use SoftDeletes;

    protected $table = 'we_card_codes';

    protected $guarded = ['id'];

}
