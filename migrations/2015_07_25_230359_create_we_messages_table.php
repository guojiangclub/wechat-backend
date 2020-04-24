<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('we_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->comment('公众号ID');
            $table->integer('fans_id')->nullable()->comment('粉丝ID 不存在时为公众号回复');
            $table->timestamp('sent_at')->nullable()->comment('消息发送时间 OR 消息回复时间');
            $table->integer('resource_id')->nullable()->comment('对应消息资源');
            $table->integer('reply_id')->nullable()->default(0)->comment('消息回复ID');
            $table->string('content',500)->comment('消息内容');
            $table->string('msg_id',25)->comment('消息id');
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
        Schema::drop('we_messages');
    }
}
