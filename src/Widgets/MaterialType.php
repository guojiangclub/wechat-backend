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
use iBrand\Wechat\Backend\Repository\MaterialRepository;

class MaterialType extends AbstractWidget
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
    public function run(MaterialRepository $material, $position)
    {
        switch ($position) {
            case 'text':
                return view('Wechat::widgets.text.index');
                break;

            case 'image':
                return view('Wechat::widgets.image.index');
                break;

            case 'video':
                return view('Wechat::widgets.video.index');
                break;

            case 'article':
                return view('Wechat::widgets.article.index');
                break;
            case 'voice':
                return view('Wechat::widgets.voice.index');
                break;
            default:
        }
    }
}
