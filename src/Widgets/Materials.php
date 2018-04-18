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



class Materials extends AbstractWidget
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
    public function run(MaterialRepository $material)
    {

         return view("Wechat::widgets.material.materials");

    }
}