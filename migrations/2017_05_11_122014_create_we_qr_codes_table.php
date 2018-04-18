<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeQrCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('we_qr_codes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('account_id');

            $table->string('name')->comment('场景名称');

            $table->string('key')->comment('关联关键字');

            $table->integer('type')->default(2);  //1临时;2永久

            $table->integer('expire_seconds')->nullable();  //过期时间 单位秒

            $table->timestamp('expire_time')->nullable();  //到期时间

            $table->string('ticket')->comment('二维码票');

            $table->integer('userid')->nullable();

            $table->string('qr_code_url')->nullable();

            $table->integer('scene_id')->nullable();

            $table->string('scene_str')->nullable();

            $table->string('url');

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
        Schema::drop('we_qr_codes');
    }
}
