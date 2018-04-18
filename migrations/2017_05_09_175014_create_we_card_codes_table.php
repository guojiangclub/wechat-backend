<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeCardCodesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('we_card_codes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('appid', 64)->comment('公众号唯一标识');
			$table->string('card_id', 100)->comment('会员卡ID');
			$table->string('code', 100)->comment('code序列号');
			$table->string('openid', 64)->comment('用户唯一标识');
			$table->timestamps();
			$table->softDeletes();

			$table->unique(['code', 'openid']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('we_card_codes');
	}
}
