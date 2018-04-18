<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('we_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->string('key',128)->comment('事件名称');
            $table->enum('type', ['addon','material'])->comment('事件类型');
            $table->enum('material_type', ['article','image', 'voice', 'video','text'])->comment('素材类型');
            $table->string('value',30)->comment('触发值'); 
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
        Schema::drop('we_events');
    }
}
