<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToWeScansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{
            Schema::table('we_scans', function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }catch (\Exception $e){

        }


        Schema::table('we_scans', function (Blueprint $table) {
            $table->integer('type');  //2普通扫描  //1关注扫描
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('we_scans', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
