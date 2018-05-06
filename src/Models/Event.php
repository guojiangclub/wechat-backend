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

class Event extends Model
{
    protected $table = 'we_events';

    protected $guarded = ['id'];

    public function material()
    {
        return $this->hasOne('iBrand\Wechat\Backend\Models\Material', 'id', 'value');
    }
}
