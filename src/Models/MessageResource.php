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

class MessageResource extends Model
{
    protected $table = 'we_message_resources';
    protected $guarded = ['id'];
}
