<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



class AddUserIdToWeFansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('we_fans', function (Blueprint $table) {
            $table->integer('user_id')->nullable();
            $table->string('unionid')->nullable();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('we_fans', function (Blueprint $table) {
            $table->dropColumn('user_id','unionid');
        });
    }
}
