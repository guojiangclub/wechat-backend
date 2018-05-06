<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$router->group(['prefix' => 'admin/wechat-api'], function () use ($router) {
    /**************************** 上传素材图片路由 **********************************/
    $router->group(['prefix' => 'upload', 'namespace' => 'Api'], function ($router) {
        $router->post('/img', 'UploadApiController@index')->name('admin.wechat-api.upload.img');
    });

    /**************************** 卡券接口路由 **********************************/
    $router->group(['prefix' => 'member/card', 'namespace' => 'Api', 'middleware' => 'wechat_account'], function ($router) {
        $router->get('/colors', 'MemberCardApiController@cardColors')->name('admin.wechat-api.member.card.colors');
        // 创建会员卡
        $router->post('/create', 'MemberCardApiController@createCard')->name('admin.wechat-api.member.card.create');
        //获取会员卡券信息
        $router->post('/getinfo', 'MemberCardApiController@getCardInfo')->name('admin.wechat-api.member.card.info');
        //获取会员卡券二维码
        $router->post('/QRCode', 'MemberCardApiController@getCardQRCode')->name('admin.wechat-api.member.card.QRCode');
        //获取会员卡Code
        $router->post('/getCode', 'MemberCardApiController@getCode')->name('admin.wechat-api.member.card.getCode');
        // 编辑更新会员卡
        $router->post('/update', 'MemberCardApiController@updateCard')->name('admin.wechat-api.member.card.update');
        // 会员卡激活
        $router->post('/membership/activate', 'MemberCardApiController@membershipActivate')->name('admin.wechat-api.member.card.membership.activate');
        // 获取会员信息
        $router->post('/membership/get', 'MemberCardApiController@membershipGet')->name('admin.wechat-api.member.card.membership.get');
        //更改会员卡信息
        $router->post('/membership/update', 'MemberCardApiController@membershipUpdate')->name('admin.wechat-api.member.card.membership.update');

        // 更新库存
        $router->post('/update/quantity', 'MemberCardApiController@updateQuantity')->name('admin.wechat-api.member.card.update.quantity');
        //删除会员卡
        $router->post('/delete', 'MemberCardApiController@deleteCard')->name('admin.wechat-api.member.card.delete');

        //指定会员卡失效
        $router->post('/disable', 'MemberCardApiController@disableCard')->name('admin.wechat-api.member.card.disable');
    });
});

$router->group(['prefix' => 'admin/wechat-api-test', 'namespace' => 'Api'], function () use ($router) {
    $router->get('/', 'MemberCardApiController@test')->name('admin.wechat-api-test');
});
