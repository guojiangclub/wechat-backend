<?php

namespace iBrand\Wechat\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class ReplyService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ReplyService';
    }
}