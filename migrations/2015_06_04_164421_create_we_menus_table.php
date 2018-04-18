<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 备注防止忘记 :
         *
         * 设计中所有的 media_id 将被替换为事件 
         */

        Schema::create('we_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->comment('所属公众号');     
            $table->integer('parent_id')->nullable()->default(0)->comment('菜单父id');
            $table->string('name', 30)->comment('菜单名称');       
            $table->enum('type', [
            'click',                                      //点击推事件
            'view',                                       //跳转URL
            'scancode_push',                              //扫码推事件
            'scancode_waitmsg',                           //扫码推事件且弹出“消息接收中”提示框
            'pic_sysphoto',                               //弹出系统拍照发图
            'pic_photo_or_album',                         //弹出拍照或者相册发图
            'pic_weixin',                                 //弹出微信相册发图器
            'location_select',                            //弹出地理位置选择器
            'media_id',                                   //下发消息（除文本消息）
            'view_limited',                               //跳转图文消息URL
                ])->default('click')->comment('菜单类型');     
            $table->string('key', 200)->nullable()->comment('菜单触发值');     
            $table->tinyInteger('sort')->nullable()->default(0)->comment('排序'); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('we_menus');
    }
}
