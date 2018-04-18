<?php

namespace iBrand\Wechat\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class QRCodeService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'QRCodeService';
    }
}
