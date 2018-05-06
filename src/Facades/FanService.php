<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class FanService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'FanService';
    }
}
