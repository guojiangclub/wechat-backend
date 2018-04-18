<?php

namespace iBrand\Wechat\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class FanService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'FanService';
    }
}
