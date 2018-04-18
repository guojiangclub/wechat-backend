<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeKeyToWeEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        try{
            Schema::table('we_events', function (Blueprint $table) {
                $table->dropColumn('key');
            });
            Schema::table('we_events', function (Blueprint $table) {
                $table->string('key',600);
            });
        }catch (\Exception $e){

        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('we_events', function (Blueprint $table) {
            $table->dropColumn('key');
        });
    }
}
