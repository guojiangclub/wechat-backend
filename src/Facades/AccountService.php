<?php

namespace iBrand\Wechat\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class AccountService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AccountService';
    }
}
