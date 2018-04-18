<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeScansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('we_scans', function (Blueprint $table) {
            $table->increments('id');

            $table->string('app_id');

            $table->string('openid')->comment('粉丝ID');

            $table->string('key')->nullable();  //场景关联关键字

            $table->string('ticket')->comment('二维码票');

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
        Schema::drop('we_scans');
    }
}
