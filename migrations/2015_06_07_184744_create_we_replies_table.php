<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('we_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->enum('type', [
                    'follow',
                    'no-match',
                    'keywords',
                ])->comment('回复类型 follow 关注回复 default 默认回复 keywords 关键词回复');  
            $table->string('name', 30)->nullable()->comment('规则名称'); //标题
            // 触发文字
            $table->string('trigger_keywords',500); //触发文字
            $table->enum('trigger_type', [
                    'equal',
                    'contain',
                ])->nullable()->comment('触发条件类型'); //默认类型
            $table->string('content')->nullable()->comment('触发内容 events');
            $table->string('group_ids')->nullable()->comment('适用范围：组id数组');
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
        Schema::drop('we_replies');
    }
}
