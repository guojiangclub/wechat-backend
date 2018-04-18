<?php

namespace iBrand\Wechat\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class CouponService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CouponService';
    }
}
