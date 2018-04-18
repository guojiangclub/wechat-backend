<?php

defined('M') || define('M', 1048576);

/**
 * 素材附件
 */
return [

	/**
	 * 图片
	 */
	'image' => [
		// 存储目录
		'storage_path'    => storage_path('app/public/wechat/materials/images/'),

		// 图片最大大小
		'upload_max_size' => 2 * M, // 5M

		// 图片路径前缀， 如果使用第三方存储请添加域名
		'prefix'          => '/wechat/materials/images',

		'allow_types' => [
			'jpeg' => 'image/jpeg',
			'jpg'  => 'image/jpg',
			'png'  => 'image/png',
			'bmp'  => 'image/bmp',
			'gif'  => 'image/gif',
		],
	],

	/**
	 * 视频
	 */
	'video' => [
		// 存储目录
		'storage_path'    => storage_path('app/public/wechat/materials/videos/'),

		// 视频最大大小
		'upload_max_size' => 10 * M, // 5M

		// 路径前缀， 如果使用第三方存储请添加域名
		'prefix'          => '/wechat/materials/videos',

		'allow_types' => [
			'mp4' => 'video/mp4',
		],
	],

	/**
	 * 声音
	 */
	'voice' => [
		// 存储目录
		'storage_path'    => storage_path('app/public/wechat/materials/voices/'),

		// 声音最大大小
		'upload_max_size' => 2 * M, // 5M

		// 路径前缀， 如果使用第三方存储请添加域名
		'prefix'          => '/wechat/materials/voices',

		'allow_types' => [
			'mp3' => 'audio/mpeg',
			'wma' => 'audio/x-ms-wma',
			'wav' => 'audio/wav',
			'amr' => 'audio/amr',
		],
	],
];