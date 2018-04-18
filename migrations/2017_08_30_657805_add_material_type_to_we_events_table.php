<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaterialTypeToWeEventsTable extends Migration
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
                $table->dropColumn('material_type');
            });
            Schema::table('we_events', function (Blueprint $table) {
                $table->enum('material_type', ['text','image', 'voice', 'video','article'])->comment('素材类型');
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
            $table->dropColumn('material_type');
        });
    }
}
