<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/25
 * Time: 16:15
 */

namespace iBrand\Wechat\Backend\Widgets;

use Arrilot\Widgets\AbstractWidget;
use iBrand\Wechat\Backend\Repository\MaterialRepository;



class OneMaterial extends AbstractWidget
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
    public function run(MaterialRepository $material,$position)
    {
        switch ($position) {
            case 'text':
                return view("Wechat::widgets.material.text");
                break;

            case 'image':
                return view("Wechat::widgets.material.image");
                break;

            case 'video':
                return view("Wechat::widgets.material.video");
                break;

            case 'article':
                return view("Wechat::widgets.material.article");
                break;
            case 'voice':
                return view("Wechat::widgets.material.voice");
                break;
            default:

        }


    }
}