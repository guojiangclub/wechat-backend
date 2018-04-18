<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeMessageResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('we_message_resources', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->string('detail',500)->comment('详细');
            $table->enum('type', [
                    'text',
                    'image',
                    'voice',
                    'shortvideo',
                    'link',
                    'location'
                ])->comment('消息类型 text 文字 image 图片 shortvideo 短视频 location 位置');
            $table->tinyInteger('status')->nullable()->default(0)->comment('同步状态 0 未同步 1 已经完成同步');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('we_message_resources');
    }
}
