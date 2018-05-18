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

use EasyWeChat\Foundation\Application;
use iBrand\Wechat\Backend\Models\Account as AccountModel;
use iBrand\Wechat\Backend\Repository\MenuRepository;

/**
 * 菜单服务提供类.
 */
class MenuService
{
    protected static $appUrl;

//    protected $menuRepository;
//
//    public function __construct(MenuRepository $menuRepository)
//    {
//        $this->menuRepository = $menuRepository;
//    }

    public function __construct()
    {
        self::$appUrl = settings('wechat_api_url');
    }

    /**
     * 取得远程公众号的菜单.
     *
     * @return array 菜单信息
     */
    private function getFromRemote(AccountModel $account)
    {
        $wechat = new Application(['app_id' => $account->app_id, 'sectet' => $account->app_secret]);
        $menus = $wechat->menu;
        $menus = $menu->current();

//        return with(new WechatMenu($account->app_id, $account->app_secret))->current();
    }

    /**
     * 同步远程菜单到本地数据库.
     *
     * @param App\Models\AccountModel $account 公众号
     *
     * @return Response
     */
    public function syncToLocal(AccountModel $account)
    {
        $remoteMenus = $this->getFromRemote($account);

        $menus = $this->makeLocalize($remoteMenus);

        return $this->saveToLocal($account->id, $menus);
    }

    /**
     * 将远程菜单进行本地化.
     *
     * @param array $menus 菜单
     *
     * @return array 处理后的菜单
     */
    private function makeLocalize($menus)
    {
        $menus = $menus['selfmenu_info']['button'];

        if (empty($menus)) {
            return [];
        }

        return $this->filterEmptyMenu(array_map([$this, 'analyseRemoteMenu'], $menus));
    }

    /**
     * 过滤掉菜单中空的内容.
     *
     * @param array $menus 菜单
     *
     * @return array
     */
    private function filterEmptyMenu($menus)
    {
        foreach ($menus as $key => $menu) {
            if (false == $menu) {
                unset($menus[$key]);
            }

            if (isset($menu['sub_button'])) {
                $menus[$key]['sub_button'] = array_filter($menu['sub_button']);
            }
        }

        return $menus;
    }

    /**
     * 分析远程取得的菜单数据.
     *
     * @param array $menu 菜单
     *
     * @return array|NULL
     */
    private function analyseRemoteMenu($menu)
    {
        if (isset($menu['sub_button']['list'])) {
            $menu['sub_button'] = array_map([$this, 'analyseRemoteMenu'], $menu['sub_button']['list']);
        } else {
            $menu = call_user_func([$this, camel_case('resolve_'.$menu['type'].'_menu')], $menu);
        }

        return $menu;
    }

    /**
     * 保存解析后台的菜单到本地.
     *
     * @param array $menus 菜单
     *
     * @return array
     */
    private function saveToLocal($accountId, $menus)
    {
        return $this->menuRepository->storeMulti($accountId, $menus);
    }

    /**
     * 解析文字类型的菜单 [转换为事件].
     *
     * @param array $menu
     *
     * @return array
     */
    private function resolveTextMenu(AccountModel $account, $menu)
    {
        $menu['type'] = 'click';

        $mediaId = $this->materialService->saveText($account->id, $menu['value']);

        $menu['key'] = $this->eventService->makeMediaId($mediaId);

        unset($menu['value']);

        return $menu;
    }

    /**
     * 解析MediaId类型的菜单.
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function resolveMediaIdMenu($menu)
    {
        return false; //暂时关掉此类型处理 todo
        $menu['type'] = 'click';
        //mediaId类型属于永久素材类型
        $menu['key'] = $this->eventService->makeMediaId();

        unset($menu['value']);

        return $menu;
    }

    /**
     * 解析新闻类型的菜单 [转换为事件/存储图文为素材].
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function resolveNewsMenu($menu)
    {
        $menu['type'] = 'click';

        $mediaId = $this->materialService->saveArticle(
            account()->getCurrent()->id,
            $menu['news_info']['list'],
            null,
            Material::CREATED_FROM_WECHAT,
            Material::CAN_NOT_EDITED //无法编辑
        );

        $menu['key'] = $this->eventService->makeMediaId($mediaId);

        unset($menu['value']);

        unset($menu['news_info']);

        return $menu;
    }

    /**
     * 解析点击事件类型的菜单 [自己的保留，否则丢弃].
     *
     * @param array $menu 菜单信息
     *
     * @return array|bool
     */
    private function resolveClickMenu($menu)
    {
        if (!$this->eventService->isOwnEvent($menu['key'])) {
            return false;
        }

        return $menu;
    }

    /**
     * 解析跳转图文MediaIdUrl类型的菜单[将被转换为View类型].
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function resolveViewLimitedMenu($menu)
    {
        return false; //暂时关闭这个功能

        $menu['type'] = 'view';

        $url = $this->materialService->localizeMaterialId($menu['value']);

        if (!$url) {
            return false;
        }

        $menu['key'] = $url;

        unset($menu['value']);

        return $menu;
    }

    /**
     * 提交菜单到微信
     */
    public function saveToRemote($menus, $app_id = null)
    {
        $app_id = empty($app_id) ? wechat_app_id() : $app_id;

        $newMenus = $this->formatToWechat($menus);

        $url = self::$appUrl.'api/menu/store?appid='.$app_id;

        $res = wechat_platform()->wxCurl($url, $newMenus);

        if (isset($res->errmsg) && 'ok' === $res->errmsg) {
            return true;
        }
        \Log::info(json_encode($res));
        return false;
    }

    /**
     * 格式化为微信菜单.
     */
    private function formatToWechat($menus)
    {
        $saveMenus = [];
        $subMenuArr = [];
        $i = -1;
        $j = -1;
        foreach ($menus as $key => $item) {
            ++$i;
            if (isset($item['child']) && count($item['child']) > 0) {
                foreach ($item['child'] as $subMenu) {
                    ++$j;
                    if ($item['id'] === $subMenu['parent_id']) {
                        $subMenuArr[$i]['sub_button'][$j]['name'] = $subMenu['name'];
                        $subMenuArr[$i]['sub_button'][$j]['type'] = $subMenu['type'];
                        if ('view' === $subMenu['type']) {
                            $subMenuArr[$i]['sub_button'][$j]['url'] = $subMenu['key'];
                        } elseif ('media_id' === $subMenu['type']) {
                            $subMenuArr[$i]['sub_button'][$j]['media_id'] = $subMenu['key'];
                        }elseif('miniprogram' === $subMenu['type']){
                            $subMenuArr[$i]['sub_button'][$j]['appid'] = $subMenu['appid'];
                            $subMenuArr[$i]['sub_button'][$j]['pagepath'] = $subMenu['pagepath'];
                            $subMenuArr[$i]['sub_button'][$j]['url'] = 'http://mp.weixin.qq.com';
                        } else {
                            $subMenuArr[$i]['sub_button'][$j]['key'] = $subMenu['key'];
                        }
                    }
                }
                $j = -1;
                $saveMenus['buttons'][$i]['name'] = $item['name'];
                $saveMenus['buttons'][$i]['sub_button'] = $subMenuArr[$i]['sub_button'];
            } else {
                $saveMenus['buttons'][$i]['name'] = $item['name'];
                $saveMenus['buttons'][$i]['type'] = $item['type'];
                if ('view' === $item['type']) {
                    $saveMenus['buttons'][$i]['url'] = $item['key'];
                } elseif ('media_id' === $item['type']) {
                    $saveMenus['buttons'][$i]['media_id'] = $item['key'];
                } elseif('miniprogram' === $item['type']){
                    $saveMenus['buttons'][$i]['appid'] = $item['appid'];
                    $saveMenus['buttons'][$i]['pagepath'] = $item['pagepath'];
                    $saveMenus['buttons'][$i]['url'] = 'http://mp.weixin.qq.com';
                } else {
                    $saveMenus['buttons'][$i]['key'] = $item['key'];
                }
            }
        }

        return $saveMenus;
    }
}
