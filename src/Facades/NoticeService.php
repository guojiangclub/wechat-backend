<?php

namespace iBrand\Wechat\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class NoticeService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'NoticeService';
    }
}