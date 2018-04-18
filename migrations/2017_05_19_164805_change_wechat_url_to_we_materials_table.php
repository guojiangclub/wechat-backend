<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeWechatUrlToWeMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        try{
            Schema::table('we_materials', function (Blueprint $table) {
                $table->dropColumn('wechat_url');
            });
            Schema::table('we_materials', function (Blueprint $table) {
                $table->string('wechat_url',600)->nullable();
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
        Schema::table('we_materials', function (Blueprint $table) {
            $table->dropColumn('wechat_url');
        });
    }
}
