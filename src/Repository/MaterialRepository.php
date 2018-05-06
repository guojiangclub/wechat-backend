<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Repository;

use iBrand\Wechat\Backend\Models\Material;
use Prettus\Repository\Eloquent\BaseRepository;

class MaterialRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Material::class;
    }

    /**
     * 获取素材列表.
     *
     * @param $where
     * @param int $limit
     * @param $time
     * @param string $order_by
     * @param string $sort
     *
     * @return mixed
     */
    public function getMaterialPaginated($where, $limit = 50, $time = [], $order_by = 'id', $sort = 'desc')
    {
        $where['parent_id'] = 0;

        return $this->scopeQuery(function ($query) use ($where,$time) {
            if (is_array($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        list($operate, $va) = $value;
                        $query = $query->where($key, $operate, $va);
                    } else {
                        $query = $query->where($key, $value);
                    }
                }
            }

            if (is_array($time)) {
                foreach ($time as $key => $value) {
                    if (is_array($value)) {
                        list($operate, $va) = $value;
                        $query = $query->where($key, $operate, $va);
                    } else {
                        $query = $query->where($key, $value);
                    }
                }
            }

            return $query->with('childrens')->orderBy('updated_at', 'desc');
        })->paginate($limit);
    }

    //获取删除图文
    public function DelArticleMaterial($media)
    {
        if (0 === $media->is_multi) {
            $this->delete($media->id);
        } else {
            $resArr = $this->findWhere(['parent_id' => $media->id])->pluck('id')->toArray();
            foreach ($resArr as $item) {
                $this->delete($item);
            }
            $this->delete($media->id);
        }

        return true;
    }

    /**
     * mediaId获取访问资源Url.
     *
     * @param string $mediaId mediaId
     *
     * @return string
     */
    public function mediaIdToSourceUrl($mediaId)
    {
        $record = $this->findByField('original_id', $mediaId)->first();

        return $record ? $record->source_url : '';
    }

    /**
     * 通过 id 获取素材.
     *
     * @param int $id 素材ID
     */
    public function getMediaById($id)
    {
        return $this->where('id', $id)->with('childrens')->first();
    }

    /**
     * 通过MediaId获取素材.
     *
     * @param string $mediaId 素材标识
     */
    public function getMaterialByMediaId($mediaId)
    {
        return $this->model->where('media_id', $mediaId)->with('childrens')->first();
    }

    /**
     * 统计图片.
     *
     * @param int $accountId accountId
     *
     * @return int
     */
    public function countImage($accountId)
    {
        return $this->model->where('account_id', $accountId)
                            ->where('parent_id', 0)
                            ->where('type', 'image')
                            ->count();
    }

    /**
     * 统计声音.
     *
     * @param int $accountId accountId
     *
     * @return int
     */
    public function countVoice($accountId)
    {
        return $this->model->where('account_id', $accountId)
                            ->where('parent_id', 0)
                            ->where('type', 'voice')
                            ->count();
    }

    /**
     * 统计图文数量.
     *
     * @param int $accountId accountId
     *
     * @return int
     */
    public function countArticle($accountId)
    {
        return $this->model->where('account_id', $accountId)
                            ->where('parent_id', 0)
                            ->where('type', 'article')
                            ->count();
    }

    /**
     * 统计视频数量.
     *
     * @param int $accountId accounId
     *
     * @return int
     */
    public function countVoide($accountId)
    {
        return $this->model->where('account_id', $accountId)
                            ->where('parent_id', 0)
                            ->where('type', 'video')
                            ->count();
    }

    /**
     * 指定素材是否已经存在.
     *
     * @param int    $accountId  账号id
     * @param string $materialId mediaId
     *
     * @return bool
     */
    public function isExists($accountId, $materialId)
    {
        return $this->model->where('account_id', $accountId)->where('original_id', $materialId)->get();
    }

    /**
     * 存储一个文字素材.
     *
     * @param int    $accountId 公众号id
     * @param string $text      文字内容
     *
     * @return string mediaId
     */
    public function storeText($accountId, $text)
    {
        $model = new $this->model();

        $model->type = 'text';

        $model->account_id = $accountId;

        $model->content = $text;

        $model->save();

        return $model;
    }

    /**
     * 存储声音素材.
     *
     * @param int     $accountId 公众号ID
     * @param Request $request   request
     *
     * @return string mediaId
     */
    public function storeVoice($accountId, $data)
    {
        $model = new $this->model();

        $model->type = 'voice';

        $model->title = $data['title'];

        $model->source_url = $data['url'];

        $model->account_id = $accountId;

        $model->save();

        return $model->media_id;
    }

    /**
     * 存储图片素材.
     *
     * @param int    $accountId   公众号ID
     * @param string $resourceUrl 图片访问地址
     * @param string $media_id    素材ＩＤ
     * @param string $wechatUrl   微信ＵＲＬ地址
     *
     * @return Response
     */
    public function storeImage($accountId, $resourceUrl, $media_id, $wechatUrl)
    {
        $model = new $this->model();

        $model->type = 'image';

        $model->account_id = $accountId;

        $model->source_url = $resourceUrl;

        $model->media_id = $media_id;

        $model->wechat_url = $wechatUrl;

        $model->save();

        return $model;
    }

    /**
     * 存储视频素材.
     */
    public function storeVideo($accountId, $data, $media_id = '')
    {
        $model = new $this->model();

        $model->type = 'video';

        $model->title = $data['title'];

        $model->description = $data['description'];

        $model->source_url = $data['url'];

        $model->account_id = $accountId;

        if (empty($media_id)) {
            $model->media_id = $media_id;
        }

        $model->save();

        return $model;
    }

    /**
     * 存储来自微信同步的图片素材.
     *
     * @param int   $accountId 公众号ID
     * @param array $image     图片信息
     *
     * @return bool
     */
    public function storeWechatImage($accountId, $image)
    {
        $model = new $this->model();

        $model->type = 'image';

        $model->title = $image['name'];

        $model->account_id = $accountId;

        $model->original_id = $image['media_id'];

        $model->source_url = $image['local_url'];

        $model->save();

        return $model;
    }

    /**
     * 存储来自微信同步的声音素材.
     *
     * @param int   $accountId 公众号Id
     * @param array $voice     声音信息
     *
     * @return bool
     */
    public function storeWechatVoice($accountId, $voice)
    {
        $model = new $this->model();

        $model->type = 'voice';

        $model->title = $voice['name'];

        $model->account_id = $accountId;

        $model->original_id = $voice['media_id'];

        $model->source_url = $voice['local_url'];

        $model->save();

        return $model->media_id;
    }

    /**
     * 存储来自微信同步的视频素材.
     *
     * @param int   $accountId 公众号ID
     * @param array $video     video
     *
     * @return bool
     */
    public function storeWechatVideo($accountId, $video)
    {
        $model = new $this->model();

        $model->type = 'video';

        $model->title = $video['title'];

        $model->description = $video['description'];

        $model->original_id = $video['media_id'];

        $model->account_id = $accountId;

        $model->source_url = $video['local_url'];

        $model->save();

        return $model->media_id;
    }

    /**
     * 获取素材本地存储Id.
     *
     * @param int    $accountId 公众号id
     * @param string $mediaId   素材id
     *
     * @return bool|string
     */
    public function getLocalMediaId($accountId, $mediaId)
    {
        $record = $this->model->where('account_id', $accountId)->where('original_id', $mediaId)->first();

        return $record ? $record->media_id : null;
    }

    //-----------------------------------存储图文------------------------------

    /**
     * 存储图文.
     */
    public function storeArticle($accountId, $articles, $media_id)
    {
        //判断多个与单个
        if (count($articles) >= 2) {
            return $this->storeMultiArticle(
                $accountId,
                $articles,
                $media_id
            );
        }

        return $this->storeSimpleArticle(
                $accountId,
                array_shift($articles),
                $media_id
            );
    }

    /**
     * 存储多图文素材.
     */
    private function storeMultiArticle(
        $accountId,
        $articles,
        $media_id
       ) {
        $firstData = array_shift($articles);
        $firstArticle = $this->savePost($media_id, $firstData, 0, $accountId, 1);
        foreach ($articles as $article) {
            $this->savePost($media_id, $article, $firstArticle->id, $accountId);
        }

        return $firstArticle->id;
    }

    /**
     * 存储单图文素材.
     */
    private function storeSimpleArticle(
        $accountId,
        $article,
        $media_id
) {
        $Article = $this->savePost($media_id, $article, 0, $accountId);

        return $Article->id;
    }

    /**
     * 保存 [针对于字段名称不统一
     */
    private function savePost($media_id, $data, $parent_id, $account_id, $is_multi = 0)
    {
        $article = [];
        $article['type'] = 'article';
        $article['account_id'] = $account_id;
        $article['parent_id'] = $parent_id;
        $article['title'] = $data['title'];
        $article['description'] = $data['description'];
        $article['author'] = $data['author'];
        $article['content'] = $data['content'];
        $article['cover_media_id'] = $data['cover_media_id'];
        $article['cover_url'] = $data['img'];
        $article['content_url'] = $data['content_url'];
        $article['show_cover_pic'] = $data['show_cover'];
        $article['is_multi'] = $is_multi;
        $article['media_id'] = $media_id;
        $res = $this->create($article);

        return $res;

//        if (isset($input['show_cover_pic'])) {
//            $showCover = $input['show_cover_pic'];
//        } else {
//            $showCover = $input['show_cover'];
//        }
//
//        if (isset($input['url'])) {
//            $sourceUrl = $input['url'];
//        } else {
//            $sourceUrl = $input['source_url'];
//        }
    }

    public function updatePost($media_id, $data, $parent_id, $account_id, $id, $is_multi = 0)
    {
        $article = [];
        $article['type'] = 'article';
        $article['account_id'] = $account_id;
        $article['parent_id'] = $parent_id;
        $article['title'] = $data['title'];
        $article['description'] = $data['description'];
        $article['author'] = $data['author'];
        $article['content'] = $data['content'];
        $article['cover_media_id'] = $data['cover_media_id'];
        $article['cover_url'] = $data['img'];
        $article['content_url'] = $data['content_url'];
        $article['show_cover_pic'] = $data['show_cover'];
        $article['is_multi'] = $is_multi;
        $article['media_id'] = $media_id;
        $res = $this->update($article, $id);

        return $res;
    }
}
