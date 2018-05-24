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
use iBrand\Wechat\Backend\Facades\MenuService;
use iBrand\Wechat\Backend\Repository\MaterialRepository;
use iBrand\Wechat\Backend\Repository\MenuRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * 菜单管理.
 */
class MenuController extends Controller
{
    protected $menuRepository;
    protected $materialRepository;

    public function __construct(MenuRepository $menuRepository,
                                MaterialRepository $materialRepository
    ) {
        $this->menuRepository = $menuRepository;
        $this->materialRepository = $materialRepository;
    }

    /**
     * 菜单.
     */
    public function index()
    {
        $push_time = settings('wechat_push_menu_time');

        $menus = $this->menuRepository->getByAccountId(wechat_id());


        return Admin::content(function (Content $content) use ($menus, $push_time) {
            $content->description('自定义菜单');

            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '基础功能', 'url' => 'wechat/base/menu','no-pjax'=>1],
                ['text' => '自定义菜单', 'url' => 'wechat/base/menu','no-pjax'=>1]

            );
            $menu='基础功能';
            $view = view('Wechat::menu.index', compact('menus', 'push_time','menu'))->render();
            $content->row($view);
        });
    }

    public function create()
    {
        $pid = !empty(request('pid')) ? request('pid') : 0;

        if (!empty($pid)) {
            $menusNumber = $this->menuRepository->getTwoMenuNumber(wechat_id(), $pid);
        } else {
            $menusNumber = $this->menuRepository->getFirstMenuNumber(wechat_id());
        }

        if (($menusNumber < 3 && 0 === $pid) || ($menusNumber < 5 && 0 !== $pid)) {
            return Admin::content(function (Content $content) {
                $content->description('添加菜单');

                if(wechat_name()){
                    $content->header(wechat_name());
                }

                $content->breadcrumb(
                    ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                    ['text' => '基础功能', 'url' => 'wechat/base/menu','no-pjax'=>1],
                    ['text' => '自定义菜单', 'url' => 'wechat/base/menu','no-pjax'=>1],
                    ['text' => '添加菜单',]

                );
                $menu='基础功能';
                $view = view('Wechat::menu.create',compact('menu'))->render();
                $content->row($view);
            });
        }

        admin_toastr('一级菜单最多3个，二级菜单最多5个','error');

        return redirect()->back();
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        $account_id = wechat_id();
        $pid = !empty(request('pid')) ? request('pid') : 0;

        if (!empty($pid)) {
            $menusNumber = $this->menuRepository->getTwoMenuNumber(wechat_id(), $pid);
        } else {
            $menusNumber = $this->menuRepository->getFirstMenuNumber(wechat_id());
        }

        if ($menusNumber >= 3 && 0 === $pid) {
            return $this->api(false, 400, '一级菜单最多3个', []);
        }

        if ($menusNumber >= 5 && 0 !== $pid) {
            return $this->api(false, 400, '二级菜单最多5个', []);
        }

        $data = [
            'name' => $input['name'],
            'parent_id' => $pid,
            'type' => $input['type'],
            'key' => $input['key'],
            'sort' => $input['sort'],
            'account_id' => $account_id,
        ];


        if ('media_id' === $data['type']) {
            $media_id = $input['key'];
            $res = $this->materialRepository->find($media_id);
            $data['key'] = $res->media_id;
        }

        if($data['type']=='miniprogram'){
            $data['key']='';
            $data['pagepath']=$input['pagepath'];
            $data['appid']=$input['appid'];
        }

        $res = $this->menuRepository->create($data);

        return $this->api(true, 200, '', $res);
    }

    public function edit($id)
    {
        $menu = $this->menuRepository->findByField('id', $id)->first();
        $material = [];
        $materials = [];

        if ('media_id' === $menu->type) {
            $materials = $this->materialRepository->findWhere(['media_id' => $menu->key])->first();
        }

        if (count($materials) > 0) {
            $material['data_selected'] = $materials->id;
            $material['data_type'] = $materials->type;
            $material['data_img'] = $materials->source_url;
            if ('article' === $materials->type) {
                $material['data_title'] = $materials->title;
                $material['data_img'] = $materials->cover_url;
                $material['data_time'] = $materials->updated_at;
            } elseif ('video' === $materials->type) {
                $material['data_title'] = $materials->title;
            }
        }

        return Admin::content(function (Content $content) use ($menu, $material) {

            $content->description('编辑菜单');
            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '基础功能', 'url' => 'wechat/base/menu','no-pjax'=>1],
                ['text' => '自定义菜单', 'url' => 'wechat/base/menu','no-pjax'=>1],
                ['text' => '编辑菜单',]

            );
            $menuinfo=$menu;
            $menu='基础功能';
            $content->body(view('Wechat::menu.edit', compact('menuinfo', 'material','menu')));
        });
    }

    public function update(Request $request)
    {
        $input = $request->except('_token');
        $account_id = wechat_id();

        $data = [
            'id' => $input['id'],
            'name' => $input['name'],
            'type' => $input['type'],
            'key' => $input['key'],
            'sort' => $input['sort'],
        ];

        if ('media_id' === $data['type']) {
            $media_id = $input['key'];
            $res = $this->materialRepository->find($media_id);
            $data['key'] = $res->media_id;
        }

        if($data['type']=='miniprogram'){
            $data['key']='';
            $data['pagepath']=$input['pagepath'];
            $data['appid']=$input['appid'];
        }

        if ($this->menuRepository->find($data['id'])->update($data)) {
            return $this->api(true, 200, '', []);
        }

        return $this->api(false, 400, '保存失败', []);
    }

    public function destroy($id)
    {
        $account_id = wechat_id();
        $menus = $this->menuRepository->findWhere(['account_id' => $account_id, 'parent_id' => $id]);
        if (count($menus) > 0) {
            return $this->api(false, 400, '含有二级级菜单删除失败', []);
        } else {
            $this->menuRepository->delete($id);
            return $this->api(true, 200, '删除成功', []);
        }

    }

    //发布菜单

    public function releaseMenu()
    {
        $app_id = wechat_app_id();
        $account_id = wechat_id();
        $menus = $this->menuRepository->getByAccountId($account_id);
        if (count($menus) > 0) {
            if (MenuService::saveToRemote($menus)) {
                settings()->setSetting(['wechat_push_menu_time' => Carbon::now()->timestamp]);

                return $this->api(true, 200, '', []);
            }

            return $this->api(false, 400, '发布失败', []);
        }

        return $this->api(false, 400, '请先添加菜单', []);
    }
}
