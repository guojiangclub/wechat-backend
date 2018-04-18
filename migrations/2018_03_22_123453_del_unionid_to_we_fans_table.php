<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



class DelUnionidToWeFansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        try
        {
            Schema::table('we_fans', function(Blueprint $table)
            {
                $table->dropColumn('unionid');
            });

        }catch(\Exception $e)
        {

        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
