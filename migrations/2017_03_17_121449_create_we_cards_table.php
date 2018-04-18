<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('we_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');    //卡券名称
            $table->string('card_id');  //返回的卡券ID
            $table->text('data');   //创建提交的数据 json
            $table->string('status')->default('off');   //状态:on 已上架，off 未上架
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
        Schema::drop('we_cards');
    }
}
