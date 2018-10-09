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
//use iBrand\Component\User\Models\UserBind;
use iBrand\Wechat\Backend\Facades\FanService;
use iBrand\Wechat\Backend\Models\Fan;
use iBrand\Wechat\Backend\Models\FanGroup;
use iBrand\Wechat\Backend\Repository\FanGroupRepository;
use iBrand\Wechat\Backend\Repository\FanRepository;
use Illuminate\Http\Request;
use Log;
use Carbon\Carbon;

/**
 * 粉丝管理.
 */
class FansController extends Controller
{
    const FANSNUM = 100;

    protected $fanRepository;

    protected $fanGroupRepository;

    public function __construct(FanRepository $fanRepository, FanGroupRepository $fanGroupRepository
    ) {
        $this->fanRepository = $fanRepository;
        $this->fanGroupRepository = $fanGroupRepository;
    }

    public function index()
    {
        $account_id = wechat_id();

        $pull_time = settings('wechat_pull_fans_time');


        $count = $this->fanRepository->findWhere(['account_id' => $account_id])->count();


        return Admin::content(function (Content $content) use ($pull_time, $count) {

            $content->description('粉丝列表');

            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '粉丝管理', 'url' => 'wechat/fans','no-pjax'=>1],
                ['text' => '粉丝列表', 'url' => 'wechat/fans','no-pjax'=>1,'left-menu-active' => '粉丝列表']

            );

            $content->body(view('Wechat::fans.index', compact('pull_time', 'count','menu')));
        });
    }

//    粉丝接口

    public function apiFansList()
    {
        $where = [];
        $time = [];
        $account_id = wechat_id();
        $group_id = intval(request('groupId'));
        $pageSize = !empty(request('pageSize')) ? request('pageSize') : 50;
        $where['account_id'] = $account_id;

        if (!empty(request('nickname'))) {
            $where['nickname'] = ['like', '%'.urlencode(request('nickname')).'%'];
        }

        if (!empty(request('groupId')) and 'all' != request('groupId')) {
            $where['tagid_list'] = ['like', '%'.','.request('groupId').','.'%'];
        }

        if (!empty(request('etime')) && !empty(request('stime'))) {
            $where['subscribed_at'] = ['<=', request('etime')];
            $time['subscribed_at'] = ['>=', request('stime')];
        }

        if (!empty(request('etime'))) {
            $time['subscribed_at'] = ['<=', request('etime')];
        }

        if (!empty(request('stime'))) {
            $time['subscribed_at'] = ['>=', request('stime')];
        }


//        $fans = $this->fanRepository->with('User')->getFansPaginated($where, $pageSize, $time)->toArray();

       $fans = $this->fanRepository->getFansPaginated($where, $pageSize, $time)->toArray();

        $count = Fan::where('account_id', $account_id)->count();

        $groups = FanService::FansGroupList();



        $account_id = wechat_id();
        if (count($groups) > 0) {
            $we_groups_count = $this->fanGroupRepository->findWhere(['account_id' => $account_id])->count();
            if ($we_groups_count and $we_groups_count != count($groups)) {
                try {
                    $this->fanGroupRepository->deleteWhere(['account_id' => $account_id]);
                } catch (\Exception $e) {
                }
            }

            foreach ($groups as $item) {
                $data = [];
                $data['title'] = $item->name;
                $data['fan_count'] = $item->count;
                $data['group_id'] = $item->id;
                $data['is_default'] = 1;
                $data['account_id'] = $account_id;
                $this->fanGroupRepository->getIdBygroupid($account_id, $item->id, $data);
            }
        }

        $groups = $this->fanGroupRepository->findWhere(['account_id' => $account_id]);

//        if(empty($group_id)){
//            $groups=$this->getFansGroupCount($groups,$account_id);
//        }
        return $this->api(true, 200, '', ['fans' => $fans, 'groups' => $groups, 'count' => $count]);
    }

//    同步拉取粉丝
    public function PullFans($next_openid = null, $num = self::FANSNUM)
    {
        $account_id = wechat_id();

        $fans = FanService::getLists($next_openid);

        if (isset($fans->data->openid) && count($fans->data->openid) > 0) {
            $openids = $fans->data->openid;
            if ($len = count($openids) >= $num) {
                $openids = array_slice($openids, 0, $num);
                $next_openid = end($openids);
                $NewOpenIds = $openids;
            } else {
                $next_openid = '';
                $NewOpenIds = $openids;
            }

            $info = FanService::getFansInfo($NewOpenIds);

            if (isset($info->user_info_list) && count($info->user_info_list) > 0) {
                foreach ($info->user_info_list as $item) {
                    $item = FanService::formatFromWeChat(collect($item)->toArray());
                    $item['account_id'] = $account_id;
                    $item['tagid_list'] = str_replace('[', ',', $item['tagid_list']);
                    $item['tagid_list'] = str_replace(']', ',', $item['tagid_list']);

//                    if ($user = UserBind::where(['type' => 'wechat', 'open_id' => $item['openid']])->first()) {
//                        $item['user_id'] = $user->user_id;
//                    }

                    try {
                        $res = $this->fanRepository->getFansByOpenid($account_id, $item['openid'], $item);
                    } catch (\Exception $e) {
                        Log::info($e);
                    }
                }
            }
        }

        if (isset($next_openid) && !empty($next_openid)) {
            $this->PullFans($next_openid);
        }

        settings()->setSetting(['wechat_pull_fans_time' => Carbon::now()->timestamp]);

        return $this->api(true, 200, '', []);
    }

    //    创建用户组
    public function storeFansGroup(Request $request)
    {
        $data = $request->except('_token');
        $account_id = wechat_id();
        $name = request('name');
        $res = FanService::createFansGroup($name);
        if (isset($res->id) && isset($res->name)) {
            $this->fanGroupRepository->create(['group_id' => $res->id, 'title' => $res->name, 'account_id' => $account_id]);

            return $this->api(true, 200, '', ['group_id' => $res->id, 'name' => $res->name]);
        }
    }

//    删除用户组
    public function delFansGroup(Request $request)
    {
        $account_id = wechat_id();

        $data = $request->except('_token');

        $group_id = request('group_id');

        FanService::delFansGroup($group_id);

        $this->fanGroupRepository->deleteWhere(['group_id' => $group_id, 'account_id' => $account_id]);

        return $this->api(true, 200, '', []);

//        $openids=[];
//        foreach ($fans as $item){
//            $openids[]=$item->openid;
//        }
//
//        if(FanService::moveUsers(['groupid'=>0,'openids'=>$openids])){
//            foreach ($openids as $item){
//                if($fans=$this->fanRepository->findWhere(['account_id'=>$account_id,'openid'=>$item])->first()){
//                    $this->fanRepository->update(['account_id'=>$account_id,'openid'=>$item,'group_id'=>0],$fans->id);
//                };
//            }
//            FanService::delFansGroup($group_id);
//            if($fansGroup){
//                $this->fanGroupRepository->delete($fansGroup->id);
//                return $this->api(true,200,'',[]);
//            }
//        };
    }

//    编辑用户组
    public function editFansGroup(Request $request)
    {
        $data = $request->except('_token');
        $input['groupid'] = request('group_id');
        $input['name'] = request('name');
        $group = $this->fanGroupRepository->findWhere(['group_id' => $input['groupid']])->first();
        if (FanService::editFansGroup($input)) {
            $this->fanGroupRepository->update(['title' => $input['name']], $group->id);

            return $this->api(true, 200, '', ['name' => $input['name']]);
        }
    }

    //获取粉丝info
    public function getInfoByOpenId($openid)
    {
        $account_id = wechat_id();
        $data = [];
        $info = $this->fanRepository->findWhere(['openid' => $openid, 'account_id' => $account_id])->first();
        $list = [];
        if ($info and $info->tagid_list and ',,' != $info->tagid_list) {
            $tagid_list = explode(',', $info->tagid_list);
            foreach ($tagid_list as $item) {
                if (!empty($item)) {
                    $list[] = $item;
                }
            }
            $fans_group = FanGroup::where('account_id', $account_id)->whereIn('group_id', $list)->get();

            if ($fans_group) {
                $info->fans_group = $fans_group;
            } else {
                $info->fans_group = $fans_group;
            }
        }

        $data = $info ? $info : [];

        return $this->api(true, 200, '', $data);
    }

    // 移动用户分组
    public function moveUsers(Request $request)
    {
        $account_id = wechat_id();
        $input = $request->except('_token');
        if (count($input['openids']) > 0) {
            if (FanService::moveUsers($input)) {
                foreach ($input['openids'] as $item) {
                    if ($fans = Fan::where(['account_id' => $account_id, 'openid' => $item])->first()) {
                        if (',,' == $fans->tagid_list || empty($fans->tagid_list)) {
                            $fans->tagid_list = ','.$input['groupid'].',';
                            $fans->save();
                        } else {
                            $tagid_list_old = $fans->tagid_list;
                            $fans->tagid_list = $tagid_list_old.$input['groupid'].',';
                            $fans->save();
                        }
                    }
                }

                return $this->api(true, 200, '', []);
            }
        }
    }

//    public function getFansGroupCount($groups,$account_id){
//        $data=[];
//        $num=[];
//        if(count($groups)>0){
//            foreach ($groups as $key=>$item){
//                $group=Fan::where('account_id',$account_id)->where('group_id',$item->group_id)->count();
//                $this->fanGroupRepository->update(['account_id'=>$account_id,'fan_count'=>$group],$item->id);
//                $num[$key]=$item->group_id;
//            }
//            $data=$this->fanGroupRepository->findWhere(['account_id'=>$account_id]);
//        }
//        return $data;
//    }

    public function delFansTag()
    {
        $account_id = wechat_id();
        $tag = request('tag');
        $open_id = request('open_id');
        if ($fans = $this->fanRepository->findWhere(['openid' => $open_id, 'account_id' => $account_id])->first()) {
            $tagid_list = $fans->tagid_list;
            $tagid_list_new = str_replace(','.$tag.',', ',', $tagid_list);
            $tagid_list_new = ',' == $tagid_list_new ? ',,' : $tagid_list_new;
            $fans = $this->fanRepository->update(['tagid_list' => $tagid_list_new], $fans->id);
            $FanGroup = FanGroup::where('account_id', $account_id)->where('group_id', $tag)->first();
            if ($FanGroup and $FanGroup->fan_count > 0) {
                $fan_count = $FanGroup->fan_count - 1;
                $FanGroup->fan_count = $fan_count;
                $FanGroup->save();
            }
            if (FanService::delFansTag(['groupid' => $tag, 'openids' => ["$open_id"]])) {
                return $this->api(true, 200, '', []);
            }
        }
    }
}
