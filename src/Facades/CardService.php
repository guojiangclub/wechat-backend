<?php

namespace iBrand\Wechat\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class CardService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CardService';
    }
}
