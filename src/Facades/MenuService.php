<?php

namespace iBrand\Wechat\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class MenuService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MenuService';
    }
}