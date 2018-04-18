<?php

namespace iBrand\Wechat\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Prettus\Repository\Traits\TransformableTrait;

class Card extends Model
{
    use SoftDeletes;

    protected $table = 'we_cards';

    protected $guarded = ['id'];

}
