<?php

namespace iBrand\Wechat\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class ServerService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ServerService';
    }
}