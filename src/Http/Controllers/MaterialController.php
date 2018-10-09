<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Http\Controllers;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use iBrand\Wechat\Backend\Facades\MaterialService;
use iBrand\Wechat\Backend\Repository\EventRepository;
use iBrand\Wechat\Backend\Repository\MaterialRepository;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    const TYPE_IMAGE = 1;
    const TYPE_ViIDE = 2;
    const TYPE_VOICE = 3;
    const TYPE_ARTICLE = 4;
    const TYPE_TEXT = 5;

    public static $DATA = [];

    protected $materialRepository;

    protected $eventRepository;

    public function __construct(MaterialRepository $materialRepository, EventRepository $eventRepository)
    {
        $this->materialRepository = $materialRepository;
        $this->eventRepository = $eventRepository;
    }

    public function index()
    {
        $account_id = wechat_id();
        if (empty(request('type')) || self::TYPE_IMAGE == request('type')) {
            $type = 'image';
            $left_menu_active='图片素材';
        } elseif (self::TYPE_ViIDE == request('type')) {
            $type = 'video';
            $left_menu_active='视频素材';
        } elseif (self::TYPE_TEXT == request('type')) {
            $type = 'text';
            $left_menu_active='文本素材';
        } elseif (self::TYPE_ARTICLE == request('type')) {
            $type = 'article';
            $left_menu_active='图文素材';
        }

        $countVideo = $this->materialRepository->findWhere(['account_id' => $account_id, 'type' => 'video'])->filter(function ($v, $k) {
            if ($v->media_id) {
                return $v;
            }
        })->count();

        $countImage = $this->materialRepository->findWhere(['account_id' => $account_id, 'type' => 'image'])->filter(function ($v, $k) {
            if ($v->media_id) {
                return $v;
            }
        })->count();

        $countText = $this->materialRepository->findWhere(['account_id' => $account_id, 'type' => 'text'])->count();

        $countArticle = $this->materialRepository->findWhere(['account_id' => $account_id, 'type' => 'article', 'parent_id' => 0])->filter(function ($v, $k) {
            if ($v->media_id) {
                return $v;
            }
        })->count();

        return Admin::content(function (Content $content) use ($type, $countImage, $countVideo, $countText, $countArticle,$left_menu_active) {
            $content->description('素材管理');

            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '素材管理', 'url' => 'wechat/material','no-pjax'=>1,'left-menu-active' => $left_menu_active]

            );

            $content->body(view('Wechat::materials.index', compact('type', 'countImage', 'countVideo', 'countText', 'countArticle')));
        });
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function upload()
    {
        return Admin::content(function (Content $content) {
            $content->body(view('Wechat::file.upload'));
        });
    }

    // 删除素材
    public function destroys($id)
    {
        self::$DATA = [];

        $media = $this->materialRepository->find($id);
        if (count($media) > 0) {
            if ($res = $this->eventRepository->findWhere(['type' => 'material', 'value' => $media->id])->first()) {
                $name = $res->key;
                $keyArr = explode(' ', $res->key);

                return $this->api(false, 400, '素材关联关键字('.$keyArr[0].')删除失败', []);
            }
            $data['mediaId'] = $media->media_id;
            if ('text' === $media->type) {
                $this->materialRepository->delete($media->id);

                return $this->api(true, 200, '', []);
            }
            $res = MaterialService::Delete($data);

            if ('article' === $media->type) {
                $this->materialRepository->DelArticleMaterial($media);

                return $this->api(true, 200, '', []);
            }

            $this->materialRepository->delete($media->id);

//            if(isset($res->errcode)&&$res->errcode===0){
//                $this->materialRepository->delete($media->id);
//            }
            return $this->api(true, 200, '', []);
        }
    }

    /**
     * 添加视频.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createVideo()
    {
        return Admin::content(function (Content $content) {
            $content->description('添加视频');

            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '素材管理', 'url' => 'wechat/material','no-pjax'=>1],
                ['text' => '视频素材', 'url' => 'wechat/material?type=2','no-pjax'=>1],
                ['text' => '添加视频','left-menu-active' => '视频素材']

            );

            $content->body(view('Wechat::materials.video.create'));
        });
    }

    /**
     * 添加音频.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createVoice()
    {
        return Admin::content(function (Content $content) {
            $content->body(view('Wechat::material.includes.voice_create'));
        });
    }

    /**
     * 添加图文.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createArticle()
    {
        return Admin::content(function (Content $content) {
            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '素材管理', 'url' => 'wechat/material','no-pjax'=>1],
                ['text' => '视频素材', 'url' => 'wechat/material?type=2','no-pjax'=>1],
                ['text' => '添加图文','left-menu-active' => '图文素材']

            );

            $content->body(view('Wechat::materials.article.create'));
        });
    }

    /**
     * 添加文本.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createText()
    {
        return Admin::content(function (Content $content) {
            $content->description('添加文本');

            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '素材管理', 'url' => 'wechat/material','no-pjax'=>1],
                ['text' => '文本素材', 'url' => 'wechat/material?type=5','no-pjax'=>1],
                ['text' => '添加文本','left-menu-active' => '文本素材']

            );

            $content->body(view('Wechat::materials.text.create'));
        });
    }

    /**
     * 编辑文本.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editText($id)
    {
        $text = $this->materialRepository->find($id);

        return Admin::content(function (Content $content) use ($text, $id) {
            $content->description('编辑文本');

            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '素材管理', 'url' => 'wechat/material','no-pjax'=>1],
                ['text' => '文本素材', 'url' => 'wechat/material?type=5','no-pjax'=>1],
                ['text' => '编辑文本','left-menu-active' => '文本素材']

            );

            $content->body(view('Wechat::materials.text.edit', compact('text', 'id')));
        });
    }

    /**
     * 更新文本.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateText(Request $request)
    {
        $data = $request->except('_token');
        if (!empty($data['id']) && !empty($data['content'])) {
//            dd($data['content']);
            $text = $this->materialRepository->find($data['id'])->update(['content' => urlencode($data['content'])]);
            $url = route('admin.wechat.material.index', ['type' => self::TYPE_TEXT]);

            return $this->api(true, 200, '', ['url' => $url]);
        }

        return $this->api(false, 400, '', []);
    }

    /**
     * 添加视频入库.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeVideo(Request $request)
    {
        if (!empty($request->all())) {
            $account_id = wechat_id();
            $id = request('id');
            $filename = request('filename');
            $data = $request->except(['_token', 'id', 'filename', 'file']);
            if (!empty($id) && !empty($filename)) {
                $Path = config('ibrand.wechat-material.video.storage_path').$filename;
                $voice = MaterialService::postRemoteVideo($Path, $data);
                $voice = json_decode($voice);
                if (isset($voice->media_id) && !empty($voice->media_id)) {
                    $video = MaterialService::getMaterialInfo($voice->media_id);
                    if (isset($video->down_url) && !empty($video->down_url)) {
                        $this->materialRepository->find($id)->update(['wechat_url' => $video->down_url, 'title' => $data['title'], 'description' => $data['description'], 'media_id' => $voice->media_id]);
                    }
                }
            }

            return redirect()->route('admin.wechat.material.index', ['type' => self::TYPE_ViIDE]);
        }
    }

    /**
     * 添加音频入库.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeVoice(Request $request)
    {
        if (!empty($request->all())) {
            $resourceUrl = config('app.url').$request->get('url');
            $account_id = wechat_id();
            $data = $request->except('_token');
            $data['url'] = $resourceUrl;
            $material = $this->materialRepository->storeVoice($account_id, $data);

            return redirect()->route('admin.wechat.material.index', ['type' => self::TYPE_VOICE]);
        }
    }

    //图文内容图片
    public function storeArticleImage($content)
    {
        if (!empty($content)) {
            $res = $this->changeContentImgSrc($content);

            if (count($res) > 0) {
                foreach ($res as $key => $item) {
                    $content = str_replace($key, $item, $content);
                }
            }
        }

        return $content;
    }

    private function changeContentImgSrc($str)
    {
        $main = [];

        $wecaht_url = [];

        preg_match_all('|(.*)src="(.*)"(.*)|isU', $str, $main);

        $url = $main[2];

        $name = [];

        $dateDir = date('Y').'/'.date('m').'/'.date('d').'/';

        $dir = storage_path('app/public/uploads/image/').$dateDir;

        is_dir($dir) || mkdir($dir, 0755, true);

        if (count($url) > 0) {
            foreach ($url as  $key => $item) {
                $newitem = substr($item, 7, 13);
                if ('mmbiz.qpic.cn' !== $newitem) {
                    $source = $dir.substr($item, strrpos($item, '/') + 1);
//                    $content = file_get_contents($item);
//                    file_put_contents($source, $content);
                    if (is_file($source)) {
                        $res = MaterialService::postRemoteArticleImage($source);
                        if (!empty($res)) {
                            $wecaht_url[$url[$key]] = $res;
                        } else {
                            $wecaht_url[$url[$key]] = '';
                        }
                    }
                } else {
                    $wecaht_url[$url[$key]] = $item;
                }
            }
        }

        return $wecaht_url;
    }

    /**
     * 添加图文入库.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeArticle(Request $request)
    {
        if (!empty($request->all())) {
            $account_id = wechat_id();
            $data = $request->except('_token');
            $data = $data['data'];
            $newData = [];
            $i = 0;
            foreach ($data as $item) {
                if (!empty($item)) {
                    $newData[$i]['title'] = $item['title'];
                    $newData[$i]['author'] = $item['author'];
                    $newData[$i]['description'] = $item['description'];
                    $newData[$i]['cover_media_id'] = $item['cover_media_id'];
                    $newData[$i]['content_url'] = $item['content_url'];
                    $newData[$i]['img'] = $item['img'];
                    $newData[$i]['show_cover'] = intval($item['show_cover']);
                    if (empty($item['content'])) {
                        $newData[$i]['content'] = $item['content'];
                    } else {
                        $newData[$i]['content'] = $this->storeArticleImage($item['content']);
                    }
                    ++$i;
                }
            }

            $description = $this->GetDescription($newData[0]['description'], $newData[0]['content']);
            $newData[0]['description'] = $description;

//             $media_id='-shkl8Ch_LihPtA06tdp8YloFB-lqpEkJlDjVY9PeSM';
            $media_id = MaterialService::postRemoteArticle($newData);

            if (isset($media_id) && !empty($media_id)) {
                $articleID = $this->materialRepository->storeArticle($account_id, $newData, $media_id);
                $article = MaterialService::getMaterialInfo($media_id);
//                  return $article->news_item;
                $wechat_url = [];
                if (isset($article->news_item) && !empty($article->create_time) && !empty($article->update_time)) {
                    $i = 0;
                }
                foreach ($article->news_item as $item) {
                    $url = $item->url;
                    $wechat_url[$i] = $url;
                    ++$i;
                }

                if (count($wechat_url) > 1) {
                    $res = $this->materialRepository->findWhere(['parent_id' => $articleID])->pluck('id')->toArray();
                    foreach ($res as $key => $item) {
                        $data['created_at'] = $article->create_time;
                        $data['updated_at'] = $article->update_time;
                        $this->materialRepository->update(['wechat_url' => $wechat_url[$key + 1]], $item);
                    }
                }

                $data['created_at'] = $article->create_time;
                $data['updated_at'] = $article->update_time;
                $this->materialRepository->update(['wechat_url' => $wechat_url[0]], $articleID);

                return $this->api(true, 200, '发布成功', []);
            }
        }
    }

    //获取摘要
    protected function GetDescription($str, $content)
    {
        if (!empty($str)) {
            return $str;
        }
        $content = mb_substr(strip_tags($content), 0, 54, 'utf-8');

        return $content;
    }

    /**
     * 添加文本入库.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeText(Request $request)
    {
        $content = request('content');
        if (!empty($content)) {
            $account_id = wechat_id();
            $material = $this->materialRepository->storeText($account_id, urlencode($content));
            $url = route('admin.wechat.material.index', ['type' => self::TYPE_TEXT]);

            return $this->api(true, 200, '', ['url' => $url]);
        }

        return $this->api(false, 400, '', []);
    }

    // 素材接口
    public function materialApi()
    {
        $type = request('type');
        $account_id = wechat_id();
        $time = [];
        $pageSize = !empty(request('pageSize')) ? request('pageSize') : 50;
        $where['account_id'] = $account_id;
        if (!empty($type)) {
            $where['type'] = $type;
        }

        if (!empty(request('keyword')) && 'text' === $type) {
            $key = request('keyword');
            $where['content'] = ['like', '%'.urldecode($key).'%'];
        }
        if (!empty(request('keyword')) && 'video' === $type) {
            $where['title'] = ['like', '%'.request('keyword').'%'];
        }
        if (!empty(request('keyword')) && 'article' === $type) {
            $where['title'] = ['like', '%'.request('keyword').'%'];
        }

        if (!empty(request('etime')) && !empty(request('stime'))) {
            $where['updated_at'] = ['<=', request('etime')];
            $time['updated_at'] = ['>=', request('stime')];
        }

        if (!empty(request('etime'))) {
            $time['updated_at'] = ['<=', request('etime')];
        }

        if (!empty(request('stime'))) {
            $time['updated_at'] = ['>=', request('stime')];
        }

        if ('text' != $type) {
            $where['media_id'] = ['<>', ''];
        }

        $materials = $this->materialRepository->getMaterialPaginated($where, $pageSize, $time)->toArray();

        return $this->api(true, 200, '', $materials);
    }

    //同步获取素材
    public function pull($i = 0)
    {
        if (0 == $i) {
            self::$DATA = [];
        }
        $j = 20 * $i;
        $type = 'image';
        $res = MaterialService::getRemoteMaterialLists($type, $j, 20);
        if (isset($res->item_count) && count($res) > 0) {
            $this->pullGetAllImages($res->item, $i);
        } else {
            $this->downloadMaterialImage();
        }
    }

    protected function pullGetAllImages($res, $i, $j = 0)
    {
        foreach ($res as $key => $item) {
//                $res=MaterialService::downloadMaterialImage($account_id,$item->media_id,$item->url,$item->name,$item->update_time);
            self::$DATA[] = $item;
        }

        return $this->pull($i + 1);
    }

    protected function downloadMaterialImage()
    {
        $account_id = wechat_id();
        $data = self::$DATA;
        if ($count = count($data) > 0) {
            $c = 0;
            foreach ($data as $item) {
                ++$c;
                $res = MaterialService::downloadMaterialImage($account_id, $item->media_id, $item->url, $item->name, $item->update_time, $c);
            }
            if ($c == $count) {
                echo 1;
            }
        }
    }

    public function delAllImage()
    {
        $account_id = wechat_id();
        if ($res = $this->materialRepository->findWhere(['account_id' => $account_id, 'type' => 'image'])) {
            foreach ($res as $item) {
                $this->materialRepository->delete($item->id);
            }
        }

        return $this->api(true, 200, '', []);
    }

    //编辑图文素材
    public function EditArticle($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->description('编辑图文');

            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '素材管理', 'url' => 'wechat/material','no-pjax'=>1],
                ['text' => '文本素材', 'url' => 'wechat/material?type=5','no-pjax'=>1],
                ['text' => '编辑图文','left-menu-active' => '图文素材']

            );

            $content->body(view('Wechat::materials.article.edit', compact('id','menu')));
        });
    }

    public function EditArticleApi($id)
    {
        $account_id = wechat_id();
        $res = $this->materialRepository->with('childrens')->findWhere(['id' => intval($id), 'account_id' => $account_id, 'type' => 'article'])->first();
        if (count($res) > 0) {
            return $this->api(true, 200, '', $res);
        }

        return $this->api(true, 200, '', []);
    }

    public function UpdateArticle(Request $request)
    {
        $account_id = wechat_id();
        $data = $request->except('_token');
        $cid = $data['cid'];
        $id = intval($data['id']);
        $data = $data['data'];

        $newData = [];
        $i = 0;
        foreach ($data as $item) {
            if (!empty($item)) {
                $newData[$i]['title'] = $item['title'];
                $newData[$i]['author'] = $item['author'];
                $newData[$i]['description'] = $item['description'];
                $newData[$i]['cover_media_id'] = $item['cover_media_id'];
                $newData[$i]['content_url'] = $item['content_url'];
                $newData[$i]['img'] = $item['img'];
                $newData[$i]['show_cover'] = intval($item['show_cover']);
                if (empty($item['content'])) {
                    $newData[$i]['content'] = $item['content'];
                } else {
                    $newData[$i]['content'] = $this->storeArticleImage($item['content']);
                }

                ++$i;
            }
        }
        $media = $this->materialRepository->find($id);
        $media_id = $media->media_id;

        if ($count = count($newData) > 0) {
            foreach ($newData as $key => $item) {
                if (MaterialService::UpdatepostRemoteArticle($media_id, $item, $key)) {
                    if (0 == $key) {
                        $is_multi = count($cid) - 1 > 0 ? 1 : 0;
                        $this->materialRepository->updatePost($media_id, $newData[$key], 0, $account_id, $id, $is_multi);
                    } else {
                        if (isset($cid[$key])) {
                            $tid = $cid[$key];
                            $tmedia = $this->materialRepository->find($tid);
                            $this->materialRepository->updatePost($tmedia->media_id, $newData[$key], $cid[0], $account_id, $tid, 0);
                        }
                    }
                }
            }
        }

        return $this->api(true, 200, '', []);
    }

    public function ArticleDestroy($id)
    {
        $media = $this->materialRepository->find($id);
        $res = MaterialService::Delete(['mediaId' => $media->media_id]);
//            dd(json_encode($res,true));
        $this->materialRepository->delete($media->id);
    }
}
