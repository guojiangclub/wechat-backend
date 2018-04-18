<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('we_accounts', function (Blueprint $table) {

            $table->increments('id');

            $table->string('name')->nullable();                            // 公众号名称

            $table->string('original_id')->nullable();                      //原始id;

            $table->string('app_id');                            // AppId

            $table->string('app_secret')->nullable();                         //AppSecret

            $table->string('token')->nullable();                              //加密token

            $table->string('aes_key')->nullable();                            //AES加密key

            $table->string('wechat_account')->nullable();                      //微信号

            $table->string('tag')->nullable();                                //接口标识;

            $table->string('access_token')->nullable();                       //微信access_token;

            $table->tinyInteger('account_type')->default(0);       //类型;       1订阅号，2服务号

            $table->tinyInteger('main')->default(0);               //主账号    0 非主账号 1 主账号

            $table->tinyInteger('sync_status')->default(0);         //同步状态 0 未同步 1 素材完成同步;

            $table->timestamps();

            $table->softDeletes();

            $table->engine = 'InnoDB';

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('we_accounts');
    }
}
