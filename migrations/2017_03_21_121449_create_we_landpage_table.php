<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeLandpageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('we_land_page', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');    //货架名称
            $table->string('url');  //返回的货架URL
            $table->string('card_id');  //卡券主键ID
            $table->integer('page_id');
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
        Schema::drop('we_land_page');
    }
}
