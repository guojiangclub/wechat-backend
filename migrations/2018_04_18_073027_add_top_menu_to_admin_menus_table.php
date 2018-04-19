<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddTopMenuToAdminMenusTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$parent = DB::table('admin_menu')->insertGetId([
			'parent_id'  => 0,
			'order'      => 0,
			'title'      => '微信管理',
			'icon'       => 'fa-tasks',
			'uri'        => 'wechat/account',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		$second = DB::table('admin_menu')->insertGetId([
			'parent_id'  => $parent,
			'order'      => 0,
			'title'      => '公众号管理',
			'icon'       => 'fa-wechat',
			'uri'        => '',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		DB::table('admin_menu')->insertGetId([
			'parent_id'  => $second,
			'order'      => 0,
			'title'      => '公众号列表',
			'icon'       => 'fa-list-ol',
			'uri'        => 'wechat/account',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		DB::table('admin_menu')->insertGetId([
			'parent_id'  => $second,
			'order'      => 0,
			'title'      => '微信设置',
			'icon'       => 'fa-expeditedssl',
			'uri'        => 'wechat/account/init',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		$basic = DB::table('admin_menu')->insertGetId([
			'parent_id'  => $parent,
			'order'      => 0,
			'title'      => '基础功能',
			'icon'       => 'fa-archive',
			'uri'        => '',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		DB::table('admin_menu')->insertGetId([
			'parent_id'  => $basic,
			'order'      => 0,
			'title'      => '自定义菜单',
			'icon'       => 'fa-align-justify',
			'uri'        => 'wechat/base/menu',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		DB::table('admin_menu')->insertGetId([
			'parent_id'  => $basic,
			'order'      => 0,
			'title'      => '自动回复',
			'icon'       => 'fa-comment-o',
			'uri'        => 'wechat/base/events',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		$fans = DB::table('admin_menu')->insertGetId([
			'parent_id'  => $parent,
			'order'      => 0,
			'title'      => '粉丝管理',
			'icon'       => 'fa-heart',
			'uri'        => '',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		DB::table('admin_menu')->insertGetId([
			'parent_id'  => $fans,
			'order'      => 0,
			'title'      => '粉丝列表',
			'icon'       => 'fa-user-md',
			'uri'        => 'wechat/fans',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		$material = DB::table('admin_menu')->insertGetId([
			'parent_id'  => $parent,
			'order'      => 0,
			'title'      => '素材管理',
			'icon'       => 'fa-clone',
			'uri'        => '',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		DB::table('admin_menu')->insertGetId([
			'parent_id'  => $material,
			'order'      => 0,
			'title'      => '图片素材',
			'icon'       => 'fa-clone',
			'uri'        => 'wechat/material?type=1',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		DB::table('admin_menu')->insertGetId([
			'parent_id'  => $material,
			'order'      => 0,
			'title'      => '视频素材',
			'icon'       => 'fa-video-camera',
			'uri'        => 'wechat/material?type=2',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		DB::table('admin_menu')->insertGetId([
			'parent_id'  => $material,
			'order'      => 0,
			'title'      => '图文素材',
			'icon'       => 'fa-file-text',
			'uri'        => 'wechat/material?type=4',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		DB::table('admin_menu')->insertGetId([
			'parent_id'  => $material,
			'order'      => 0,
			'title'      => '文本素材',
			'icon'       => 'fa-file-text-o',
			'uri'        => 'wechat/material?type=5',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		$notice = DB::table('admin_menu')->insertGetId([
			'parent_id'  => $parent,
			'order'      => 0,
			'title'      => '模板消息',
			'icon'       => 'fa-external-link',
			'uri'        => '',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		DB::table('admin_menu')->insertGetId([
			'parent_id'  => $notice,
			'order'      => 0,
			'title'      => '我的模板',
			'icon'       => 'fa-sitemap',
			'uri'        => 'wechat/notice',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		$qr_code = DB::table('admin_menu')->insertGetId([
			'parent_id'  => $parent,
			'order'      => 0,
			'title'      => '二维码管理',
			'icon'       => 'fa-bookmark',
			'uri'        => '',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		DB::table('admin_menu')->insertGetId([
			'parent_id'  => $qr_code,
			'order'      => 0,
			'title'      => '二维码列表',
			'icon'       => 'fa-qrcode',
			'uri'        => 'wechat/QRCode',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);

		DB::table('admin_menu')->insertGetId([
			'parent_id'  => $qr_code,
			'order'      => 0,
			'title'      => '扫码统计',
			'icon'       => 'fa-ambulance',
			'uri'        => 'wechat/QRCode/count/scans',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}
}
