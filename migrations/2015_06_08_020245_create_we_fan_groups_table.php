<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeFanGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('we_fan_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->nullable()->comment('所属公众号');
			$table->integer('group_id')->nullable()->comment('粉丝组group_id');
			$table->string('title',90)->nullable()->comment('组名');
			$table->integer('fan_count')->nullable()->default(0)->comment('粉丝数');
			$table->tinyInteger('is_default')->nullable()->default(1)->comment('是否为默认组:1=默认,0=自建');
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
        Schema::drop('we_fan_groups');
    }
}
