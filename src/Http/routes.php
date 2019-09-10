<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$router->group(['middleware' => 'web'], function () use ($router) {
    $router->group(['prefix' => 'wechat_call_back'], function () use ($router) {
        $router->get('/message', 'CallBackMessageController@index');
        $router->get('/event', 'CallBackEventController@event');
        $router->get('/event/user_get_card', 'CallBackEventController@UserGetCard');
    });

    //$router->group(['prefix' => 'admin/wechat'], function () use ($router) {

    $router->group(['prefix' => 'admin/wechat', 'middleware' => 'admin'], function () use ($router) {
        $router->get('/init', 'WechatController@wechatInit')->name('admin.wechat.init');

        $router->post('/saveSettings', 'WechatController@saveSettings')->name('admin.wechat.saveSettings');

        $router->get('/platform/auth', 'WechatController@platformAuth')->name('admin.wechat.platform.auth');

        $router->get('/', 'WechatController@index')->name('admin.wechat.index');

        $router->get('/account', 'AccountController@index')->name('admin.wechat.account.index');

        $router->get('/{app_id}/management', 'AccountController@getChangeAccount')->name('admin.wechat.management');

        Route::any('/api', 'ServerController@server');

//        $router->get('/base/{html}', function (){
//
//        });


        // 公众号管理
        $router->get('/account/create', 'AccountController@create')->name('admin.wechat.account.create');
        $router->post('/account/store', 'AccountController@store')->name('admin.wechat.account.store');
        $router->post('/account/{id}/delete', 'AccountController@destroy')->name('admin.wechat.account.destroy');
        $router->get('/account/{id}/edit', 'AccountController@edit')->name('admin.wechat.account.edit');
        $router->post('/account/{id}/update', 'AccountController@update')->name('admin.wechat.account.update');

        $router->group(['middleware' => 'wechat_account'], function ($router) {
            /**************************** 素材管理的路由 **********************************/
            $router->group(['prefix' => 'material'], function ($router) {
                $router->get('/', 'MaterialController@index')->name('admin.wechat.material.index');

                // 视频
                $router->get('/create_video', 'MaterialController@createVideo')->name('admin.wechat.material.create_video');

                $router->post('/store_video', 'MaterialController@storeVideo')->name('admin.wechat.material.store_video');

                // 音频
                $router->get('/create_voice', 'MaterialController@createVoice')->name('admin.wechat.material.create_voice');

                $router->post('/store_voice', 'MaterialController@storeVoice')->name('admin.wechat.material.store_voice');

                // 图文
                $router->get('/create_article', 'MaterialController@createArticle')->name('admin.wechat.material.create_article');

                $router->post('/store_article', 'MaterialController@storeArticle')->name('admin.wechat.material.store_article');

                // 文本
                $router->get('/create_text', 'MaterialController@createText')->name('admin.wechat.material.create_text');

                $router->get('/{id}/edit_text', 'MaterialController@editText')->name('admin.wechat.material.edit_text');

                $router->post('/store_text', 'MaterialController@storeText')->name('admin.wechat.material.store_text');

                $router->post('/update_text', 'MaterialController@updateText')->name('admin.wechat.material.update_text');

                // 图片上传
                $router->get('/upload', 'MaterialController@upload')->name('admin.wechat.material.upload');

                $router->get('/userPics', 'MaterialController@userPics')->name('admin.wechat.material.userPics');

                // 文件上传

                $router->post('/upload', 'UploadController@index')->name('admin.wechat.upload');

                //删除素材

                $router->post('/{id}/delete', 'MaterialController@destroys')->name('admin.wechat.material.delete');

                //json接口
                $router->get('/api/material', 'MaterialController@materialApi')->name('admin.wechat.material.api');

                //pull素材

                $router->get('/pull/image', 'MaterialController@pull')->name('admin.wechat.material.pull');

                $router->get('/all-del-image', 'MaterialController@delAllImage');

//            编辑图文素材
                $router->get('/edit/{id}/article', 'MaterialController@EditArticle')->name('admin.wechat.material.edit.article');

                $router->get('/edit/article/{id}/api', 'MaterialController@EditArticleApi')->name('admin.wechat.material.edit.article.api');

                $router->post('/update/article', 'MaterialController@UpdateArticle')->name('admin.wechat.material.update.article');

                $router->post('/article/{id}/delete', 'MaterialController@ArticleDestroy')->name('admin.wechat.material.article.delete');
            });

            /**************************** 微信菜单的路由 **********************************/

            $router->group(['prefix' => 'base/menu'], function ($router) {
                $router->get('/', 'MenuController@index')->name('admin.wechat.menu.index');

                $router->get('/create', 'MenuController@create')->name('admin.wechat.menu.create');

                $router->post('/store', 'MenuController@store')->name('admin.wechat.menu.store');

                $router->get('/{id}/edit', 'MenuController@edit')->name('admin.wechat.menu.edit');

                $router->post('/update', 'MenuController@update')->name('admin.wechat.menu.update');

                $router->post('/{id}/delete', 'MenuController@destroy')->name('admin.wechat.menu.delete');

                $router->post('/release', 'MenuController@releaseMenu')->name('admin.wechat.menu.release');

                $router->post('/{id}/store', 'MenuController@storeTwoLevelMenu')->name('admin.wechat.menu.store.TwoLevelMenu');
            });

            /**************************** 微信事件自动回复管理路由 **********************************/

            $router->group(['prefix' => 'base/events'], function ($router) {
                $router->get('/', 'EventsController@index')->name('admin.wechat.events.index');

                $router->get('/api', 'EventsController@apiEvents')->name('admin.wechat.events.api');

                $router->get('/create', 'EventsController@create')->name('admin.wechat.events.create');

                $router->post('/store', 'EventsController@store')->name('admin.wechat.events.store');

                $router->post('/{id}/delete', 'EventsController@destroy')->name('admin.wechat.events.delete');

                $router->get('/{id}/edit', 'EventsController@edit')->name('admin.wechat.events.edit');

                $router->get('/api/{id}/edit', 'EventsController@apiEdit')->name('admin.wechat.events.api.edit');

                $router->post('/{id}/update', 'EventsController@update')->name('admin.wechat.events.update');
            });

            /**************************** 微信二维码管理 **********************************/
            $router->group(['prefix' => 'QRCode'], function ($router) {
                $router->get('/', 'QRCodeController@index')->name('admin.wechat.QRCode.index');

                $router->get('/api', 'QRCodeController@apiQRCodes')->name('admin.wechat.QRCode.api');

                $router->get('/create', 'QRCodeController@create')->name('admin.wechat.QRCode.create');

                $router->post('/store', 'QRCodeController@store')->name('admin.wechat.QRCode.store');

                $router->post('/{id}/delete', 'QRCodeController@destroy')->name('admin.wechat.QRCode.delete');

                $router->get('/edit/{id}', 'QRCodeController@edit')->name('admin.wechat.QRCode.edit');

                $router->get('/api/edit/{id}', 'QRCodeController@apiEdit')->name('admin.wechat.QRCode.api.edit');

                $router->post('/update/{id}', 'QRCodeController@update')->name('admin.wechat.QRCode.update');

                $router->get('/scans', 'QRCodeController@scans')->name('admin.wechat.QRCode.scans');

                $router->get('/api/scans', 'QRCodeController@apiScans')->name('admin.wechat.QRCode.api.scans');

                // 扫码统计
                $router->get('/count/scans', 'ScansController@index')->name('admin.wechat.QRCode.count.scans');

                $router->get('/count/api/scans', 'ScansController@apiScans')->name('admin.wechat.QRCode.count.api.scans');

                $router->get('getExportData', 'ScansController@getExportData')->name('admin.scans.getExportData');
            });

            /**************************** 微信粉丝的路由 **********************************/

            $router->group(['prefix' => 'fans'], function ($router) {
                $router->get('/', 'FansController@index')->name('admin.wechat.fans.index');

                $router->get('/api/list', 'FansController@apiFansList')->name('admin.wechat.fans.api');

                $router->post('/PullFans', 'FansController@PullFans')->name('admin.wechat.fans.PullFans');

                $router->post('/group/store', 'FansController@storeFansGroup')->name('admin.wechat.fans.group.store');

                $router->post('/group/del', 'FansController@delFansGroup')->name('admin.wechat.fans.group.del');

                $router->post('/group/update', 'FansController@editFansGroup')->name('admin.wechat.fans.group.update');

                $router->get('/info/{openid}', 'FansController@getInfoByOpenId')->name('admin.wechat.fans.info');

                $router->post('/group/move/users', 'FansController@moveUsers')->name('admin.wechat.fans.move.users');

                $router->post('/tag/move/users', 'FansController@delFansTag')->name('admin.wechat.fans.move.tag');
            });

            /**************************** 微信模板消息的路由 **********************************/
            $router->group(['prefix' => 'notice'], function ($router) {
                $router->get('/', 'NoticeController@index')->name('admin.wechat.notice.index');

                $router->get('/{id}/info', 'NoticeController@show')->name('admin.wechat.notice.show');

                $router->get('/{id}/sendOut', 'NoticeController@sendOutEdit')->name('admin.wechat.notice.sendOut.edit');
                // 发送模板消息
                $router->post('/sendOut', 'NoticeController@sendOut')->name('admin.wechat.notice.sendOut');
            });

            /**************************** 微信卡劵的路由 **********************************/
//        $router->group(['prefix' => 'card'], function ($router) {
//                      $router->get('/', 'CardController@index')->name('admin.wechat.card.index');
//
//            $router->get('/create', 'CardController@create')->name('admin.wechat.card.create');
//
//            $router->post('/store', 'CardController@store')->name('admin.wechat.card.store');
//
//            $router->delete('/delete/{id}', 'CardController@deleteCard')->name('admin.wechat.card.delete');

//            $router->get('landingPage', 'CardController@landingPage')->name('admin.wechat.landingPage.index');
//            $router->get('landingPage/create', 'CardController@createLandingPage')->name('admin.wechat.landingPage.create');
//            $router->post('landingPage/store', 'CardController@storeLandingPage')->name('admin.wechat.landingPage.store');

//        });
        });
    });


});
