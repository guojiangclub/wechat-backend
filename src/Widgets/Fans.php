<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Widgets;

use Arrilot\Widgets\AbstractWidget;
use iBrand\Wechat\Backend\Repository\FanRepository;

class Fans extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run(FanRepository $fans)
    {
        return view('Wechat::widgets.fans.index');
    }
}
