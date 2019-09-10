# iBrand 微信公众号平台管理系统

可快速托管微信公众号并实现公众号菜单管理、自动回复、粉丝管理、素材管理（视频素材，图片素材，图文素材，文本素材）、模板消息以及二维码管理等功能。

- 基于 [iBrand 第三方平台](https://github.com/ibrandcc/laravel-wechat-platform) 开发
- 后台基于 [iBrand Backend](https://github.com/ibrandcc/backend)

##  安装

```
composer require ibrand/wechat-backend:~1.0 -vvv
```

### 在 config/app.php 注册 ServiceProvider 
```
'providers' => [
    // ...
    HieuLe\Active\ActiveServiceProvider::class,
    iBrand\Wechat\Backend\Providers\BackendServiceProvider::class,
],

'aliases' => [
    // ...
     'Active' => HieuLe\Active\Facades\Active::class,
],

```

### 发布资源配置

```
php artisan vendor:publish --all
```

### 在config/laravel-widgets中添加

```
'default_namespace' => 'iBrand\Wechat\Backend\Widgets',
```

### 初始化表数据

```
php artisan ibrand-wechat-backend:install
```

## 使用

使用前，请申请并部署好自己的微信第三方开放平台，获取 client_id 和 client_secret.

//TODO: 待完善






