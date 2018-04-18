<?php

namespace iBrand\Wechat\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	protected $table = 'we_events';
	
	protected $guarded = ['id'];


    public function material()
    {
        return $this->hasOne('iBrand\Wechat\Backend\Models\Material', 'id','value');
    }





}


