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

## 果酱云社区

<p align="center">
  <a href="https://guojiang.club/" target="_blank">
    <img src="https://cdn.guojiang.club/image/2022/02/16/wu_1fs0jbco2182g280l1vagm7be6.png" alt="点击跳转"/>
  </a>
</p>



- 全网真正免费的IT课程平台

- 专注于综合IT技术的在线课程，致力于打造优质、高效的IT在线教育平台

- 课程方向包含Python、Java、前端、大数据、数据分析、人工智能等热门IT课程

- 300+免费课程任你选择



<p align="center">
  <a href="https://guojiang.club/" target="_blank">
    <img src="https://cdn.guojiang.club/image/2022/02/16/wu_1fs0l82ae1pq11e431j6n17js1vq76.png" alt="点击跳转"/>
  </a>
</p>