<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



class AddUserIdToWeCodeCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('we_accounts', function (Blueprint $table) {
                $table->integer('service_type_info')->nullable();
       });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('we_accounts', function (Blueprint $table) {
            $table->dropColumn('service_type_info');
        });
    }
}
