<?php

namespace iBrand\Wechat\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class EventService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'EventService';
    }
}
