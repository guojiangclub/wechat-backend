<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
