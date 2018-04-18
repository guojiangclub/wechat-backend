<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeFanReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('we_fan_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->nullable()->comment('所属公众号');
			$table->string('openid',100)->nullable()->comment('OPENID');
			$table->string('type',100)->comment('操作类型');
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
        Schema::drop('we_fan_reports');
    }
}
