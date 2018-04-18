<?php

namespace iBrand\Wechat\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class MessageService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MessageService';
    }
}
