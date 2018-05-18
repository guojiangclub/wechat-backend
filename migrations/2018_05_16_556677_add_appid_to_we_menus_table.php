<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



class AddAppidToWeMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('we_menus', function (Blueprint $table) {
            $table->string('appid')->nullable();
            $table->string('pagepath')->nullable();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('we_menus', function (Blueprint $table) {
            $table->dropColumn('appid','pagepath');
        });
    }
}
