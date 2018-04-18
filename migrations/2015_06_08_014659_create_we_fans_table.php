<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeFansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('we_fans', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('account_id')->nullable()->comment('所属公众号');
			$table->integer('group_id')->nullable()->comment('粉丝组group_id');
			$table->string('openid',100)->nullable()->comment('OPENID');
			$table->string('nickname',300)->nullable()->comment('昵称');
			$table->string('signature',300)->nullable()->comment('签名');
			$table->text('remark')->nullable()->comment('备注');
			$table->enum('sex', ['女','男'])->nullable()->comment('性别');
			$table->string('language',300)->nullable()->comment('语言');
			$table->string('city',300)->nullable()->comment('城市');
			$table->string('province',300)->nullable()->comment('省');
			$table->string('country',300)->nullable()->comment('国家');
			$table->string('avatar',300)->nullable()->comment('头像');
			$table->integer('unionid')->nullable()->comment('unionid');
			$table->integer('liveness')->nullable()->comment('用户活跃度');
             // 关注时间
			$table->timestamp('subscribed_at')->nullable();
           // 最后一次在线时间
			$table->timestamp('last_online_at')->nullable();
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
        Schema::drop('we_fans');
    }
}
