<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Services;

use iBrand\Wechat\Backend\Models\Material;
use iBrand\Wechat\Backend\Repository\MaterialRepository;

/**
 * 素材服务.
 */
class MaterialService
{
    /**
     * 拉取素材默认起始位置.
     */
    const MATERIAL_DEFAULT_OFFSET = 0;

    /**
     * 拉取素材的最大数量.
     */
    const MATERIAL_MAX_COUNT = 20;

    /**
     * materialRepository.
     */
    private $materialRepository;

//    private $wechat;

    /**
     * media.
     */
    private $mediaService;

    protected static $appUrl;
    protected static $code;

    public function __construct()
    {
        self::$appUrl = settings('wechat_api_url');
        self::$code = config('wechat-error-code');
    }

    /**
     * 保存图文消息.
     *
     * @param array $articles 图文消息
     *
     * @return array
     */
    public function saveArticle(
        $accountId,
        $articles,
        $originalMediaId,
        $createdFrom,
        $canEdited)
    {
        return $this->materialRepository->storeArticle(
            $accountId,
            $articles,
            $originalMediaId,
            $createdFrom,
            $canEdited
        );
    }

    /**
     * 存储一个文字回复消息.
     *
     * @param int    $accountId 公众号ID
     * @param string $text      文字内容
     *
     * @return Response
     */
    public function saveText($accountId, $text)
    {
        return $this->materialRepository->storeText($accountId, $text);
    }

    /**
     * 素材转为本地素材.
     *
     * @param string $mediaId     素材id
     * @param string $mediaType   素材类型
     * @param bool   $isTemporary 是否是临时素材
     *
     * @return string 生成的自己的MediaId
     */
    public function localizeMaterialId($mediaId, $mediaType, $isTemporary = true)
    {
        // var_dump($mediaId);
        // die();
    }

    /**
     * 检测素材是否存在.
     *
     * @param string $materialId 素材id
     *
     * @return bool
     */
    public function isExists($materialId)
    {
        return $this->materialRepository->isExists($this->account->id, $materialId);
    }

    /**
     * 删除永久素材.
     */
    public function Delete($Data, $app_id = null)
    {
        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/medias/delete?appid='.$app_id;

        $res = wechat_platform()->wxCurl($url, $Data);

        return $res;
    }

    //获取素材信息
    public function getMaterialInfo($material_id, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $data['mediaId'] = $material_id;

        $url = self::$appUrl.'api/medias/get?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;
        } else {
            return $res;
        }

        return $return;
    }

    //   --------------------- 图片----------------------

    /**
     * 上传图片到远程服务.
     *
     * @return string 微信素材id
     */
    public function postRemoteImage($path, $app_id = null)
    {
        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/medias/remote/image?appid='.$app_id;

        $image = wechat_platform()->upload('image', $path, $url);

        return $image;
    }

    /**
     * 上传图文图片内容到远程服务.
     *
     * @return string 微信素材id
     */
    public function postRemoteArticleImage($path, $app_id = null)
    {
        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/medias/remote/article/image?appid='.$app_id;

        $image = wechat_platform()->upload('image', $path, $url);

        return $image;
    }

    //   --------------------- 视频----------------------

    /**
     * 上传视频到远程服务.
     *
     * @return string 微信素材id
     */
    public function postRemoteVideo($path, $data, $app_id = null)
    {
        $app_id = empty($app_id) ? wechat_app_id() : $app_id;
        $title = $data['title'];
        $description = $data['description'];
        $url = self::$appUrl.'api/medias/remote/video?appid='.$app_id.'&title='.$title.'&description='.$description;

        $video = wechat_platform()->upload('video', $path, $url);

        return $video;
    }

    //   --------------------- 图文-----------------------

    /**
     * 上传图文到远程服务.
     *
     * @return string 微信素材id
     */
    public function postRemoteArticle($data, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/medias/remote/article?appid='.$app_id;

        $code = self::$code;

        $article = $this->RemoteArticleData($data);

        \Log::info($article);

        $res = wechat_platform()->wxCurl($url, $article);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;

            return $return;
        }

        if (isset($res->media_id) && !empty($res->media_id)) {
            return $res->media_id;
        }

        return null;
    }

    /**
     * 修改图文.
     *
     * @return string 微信素材id
     */
    public function UpdatepostRemoteArticle($mediaId, $data, $index = null, $app_id = null)
    {
        $return = [];

        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/medias/update/article?appid='.$app_id;

        $code = self::$code;

        $article['title'] = $data['title'];
        $article['author'] = $data['author'];
        $article['digest'] = $data['description'];
        $article['thumb_media_id'] = $data['cover_media_id'];
        $article['show_cover'] = intval($data['show_cover']);
        $article['content'] = $data['content'];
        $article['content_source_url'] = $data['content_url'];

        $articleDate = [
            'mediaId' => $mediaId,
            'data' => $article,
        ];

        if (null !== $index) {
            $articleDate['index'] = $index;
        }

        $res = wechat_platform()->wxCurl($url, $articleDate);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;

            return $return;
        }

        if (isset($res->errmsg) && 'ok' === $res->errmsg) {
            return true;
        }

        return false;
    }

    //处理图文格式化数据
    protected function RemoteArticleData($articles)
    {
//        判断多个与单个
        if (count($articles) >= 2) {
            return $this->storeMultiArticle($articles);
        }

        return $this->storeSimpleArticle(array_shift($articles));
    }

    /**
     * 处理单图文格式数据.
     */
    private function storeSimpleArticle($data)
    {
        $article = [];
        $article['title'] = $data['title'];
        $article['author'] = $data['author'];
        $article['digest'] = $data['description'];
        $article['thumb_media_id'] = $data['cover_media_id'];
        $article['show_cover'] = $data['show_cover'];
        $article['content'] = $data['content'];
        $article['source_url'] = $data['content_url'];

        return $article;
    }

    //处理多图文格式数据.
    private function storeMultiArticle($articles)
    {
        $data = [];
        foreach ($articles as $article) {
            $data[] = $this->storeSimpleArticle($article);
        }

        return $data;
    }

    /**
     * 同步远程素材到本地.
     *
     * @param Account $account 当前公众号
     * @param string  $type    素材类型
     *
     * @return Response
     */
    public function syncRemoteMaterial($account, $type)
    {
        $countNumber = $this->getRemoteMaterialCount($account, $type);

        for ($offset = self::MATERIAL_DEFAULT_OFFSET;
             $offset < $countNumber;
             $offset += self::MATERIAL_MAX_COUNT
        ) {
            $lists = $this->getRemoteMaterialLists($account, $type, $offset, self::MATERIAL_MAX_COUNT);

            $this->localizeRemoteMaterialLists($account, $lists, $type);
        }
    }

    /**
     * 远程素材存储本地.
     *
     * @param Account $account 公众号
     * @param array   $lists   素材列表
     * @param string  $type
     *
     * @return Response
     */
    private function localizeRemoteMaterialLists($account, $lists, $type)
    {
        return array_map(function ($list) use ($type, $account) {
            $callFunc = 'storeRemote'.ucfirst($type);

            return $this->$callFunc($account, $list);
        }, $lists);
    }

    /**
     * 存储远程图片素材.
     *
     * @param Account $account 公众号
     * @param array   $image   素材信息
     *
     * @return Response
     */
    private function storeRemoteImage($account, $image)
    {
        $mediaId = $image['media_id'];

        if ($this->getLocalMediaId($account->id, $mediaId)) {
            return;
        }

        $image['local_url'] = config('app.url').$this->downloadMaterial($account, 'image', $mediaId);

        return $this->materialRepository->storeWechatImage($account->id, $image);
    }

    /**
     * 存储远程声音素材.
     *
     * @param array $voice 声音素材
     *
     * @return Response
     */
    private function storeRemoteVoice($account, $voice)
    {
        $mediaId = $voice['media_id'];

        if ($this->getLocalMediaId($account->id, $mediaId)) {
            return;
        }

        $voice['local_url'] = config('app.url').$this->downloadMaterial($account, 'voice', $mediaId);

        return $this->materialRepository->storeWechatVoice($account->id, $voice);
    }

    /**
     * 存储远程视频素材.
     *
     * @param array $video 素材信息
     *
     * @return Response
     */
    private function storeRemoteVideo($account, $video)
    {
        $mediaId = $video['media_id'];

        if ($this->getLocalMediaId($account->id, $mediaId)) {
            return;
        }

        $videoInfo = $this->downloadMaterial($account, 'video', $mediaId);

        return $this->materialRepository->storeWechatVideo($account->id, $videoInfo);
    }

    /**
     * 存储远程图文素材.
     *
     * @param array $news 图文
     *
     * @return Response
     */
    private function storeRemoteNews($account, $news)
    {
        $mediaId = $news['media_id'];

        if ($this->getLocalMediaId($account->id, $mediaId)) {
            return;
        }
        $news['content']['news_item'] = $this->localizeNewsCoverMaterialId($account, $news['content']['news_item']);

        return $this->materialRepository->storeArticle(
            $account->id,
            $news['content']['news_item'],
            $news['media_id']
        );
    }

    /**
     * 将图文消息中的素材转换为本地.
     *
     * @param Account $account   公众号
     * @param array   $newsItems newItem
     *
     * @return array
     */
    private function localizeNewsCoverMaterialId($account, $newsItems)
    {
        $newsItems = array_map(function ($item) {
            $item['cover_url'] = $this->mediaIdToSourceUrl($item['thumb_media_id']);

            return $item;
        }, $newsItems);

        return $newsItems;
    }

    /**
     * mediaId转换为本地Url.
     *
     * @param string $mediaId mediaId
     *
     * @return string
     */
    private function mediaIdToSourceUrl($mediaId)
    {
        return $this->materialRepository->mediaIdToSourceUrl($mediaId);
    }

    //--------------------------同步-------------------------------

    /**
     * 下载图片素材到本地.
     */
    public function downloadMaterialImage($account_id, $media_id, $url, $name, $update_time, $c)
    {
//        $dateDir = date('Ym').'/';
        $dateDir = '';
        $dir = config('wechat-material.image.storage_path').$dateDir;

        is_dir($dir) || mkdir($dir, 0755, true);

        $Filename = md5($media_id);

        $png = substr(strrchr($name, '.'), 1);

        $source = $dir.$Filename.'.'.$png;

        if (Material::where(['media_id' => $media_id])->get()) {
            $time = date('Y-m-d H:s:i', $update_time);
            $content = file_get_contents($url);
            file_put_contents($source, $content);
            if (is_file($source)) {
                $source_url = $_SERVER['APP_URL'].'/storage/wechat/materials/images/'.$Filename.'.'.$png;
                if (!$res = Material::where(['media_id' => $media_id, 'account_id' => $account_id])->first()) {
                    $data = [
                        'account_id' => $account_id,
                        'media_id' => $media_id,
                        'type' => 'image',
                        'source_url' => $source_url,
                        'wechat_url' => $url,
                        'created_at' => $time,
                        'updated_at' => $time,
                    ];
                    Material::create($data);
                } else {
                    Material::where('id', $res->id)->update(['wechat_url' => $url, 'updated_at' => $time]);
                }
            }
        }

        return $c;
    }

    /**
     * 获取远程素材列表.image,news,video.
     */
    public function getRemoteMaterialLists($type, $offset = 0, $count = 20, $app_id = null)
    {
        $return = [];
        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/medias/lists?appid='.$app_id;

        $code = self::$code;

        $data['type'] = $type;

        $data['offset'] = $offset;

        $data['count'] = $count;

        $res = wechat_platform()->wxCurl($url, $data);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;

            return $return;
        }
        if (isset($res->item) && count($res->item) > 0) {
            return $res;
        }

        return $return;
    }

    /**
     * 取得远程素材的数量image,news,video.
     */
    public function getRemoteMaterialCount($type = 'all', $app_id = null)
    {
        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $url = self::$appUrl.'api/medias/stats?appid='.$app_id;

        $code = self::$code;

        $res = wechat_platform()->wxCurl($url);

        if (isset($res->errcode) && 0 !== $res->errcode) {
            $return['errcode'] = $res->errcode;
            $return['errmsg'] = isset($code[$res->errcode]) ? $code[$res->errcode] : $res->errmsg;

            return $return;
        }

        $data = collect($res)->toArray();

        if ('all' === $type) {
            return $data;
        }
        $newtype = $type.'_count';
        if (isset($data[$newtype])) {
            return $data[$newtype];
        }

        return '';
    }

    //--------------------------同步-------------------------------

    /**
     * 获取本地存储素材id.
     *
     * @param int    $accountId 公众号id
     * @param string $mediaId   素材id
     *
     * @return NULL|string
     */
    private function getLocalMediaId($accountId, $mediaId)
    {
        return $this->materialRepository->getLocalMediaId($accountId, $mediaId);
    }
}
