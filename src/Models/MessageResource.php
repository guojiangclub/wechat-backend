<?php

namespace iBrand\Wechat\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class MessageResource extends Model
{
	protected $table = 'we_message_resources';
	protected $guarded = ['id'];
}
