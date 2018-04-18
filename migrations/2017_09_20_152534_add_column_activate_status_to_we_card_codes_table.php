<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnActivateStatusToWeCardCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('we_card_codes', function (Blueprint $table) {
			$table->integer('activate_status')->default(0)->comment('是否激活 0未激活 1已激活')->after('openid');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('we_card_codes', function (Blueprint $table) {
		    $table->dropColumn('activate_status');
	    });
    }
}
