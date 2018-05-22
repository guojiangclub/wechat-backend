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
use iBrand\Wechat\Backend\Facades\QRCodeService;
use iBrand\Wechat\Backend\Repository\QRCodeRepository;
use iBrand\Wechat\Backend\Repository\ScanRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * 二维码管理.
 */
class QRCodeController extends Controller
{
    const QRCode_TYPE_FOREVER = 2; //永久二维码
    const QRCode_TYPE_TEMPORARY = 1; //临时二维码

    const DEFAULT_SCANS = 2;  //扫描
    const FOLLOW_SCANS = 1;  //关注

    protected $QRCodeRepository;
    protected $scanRepository;

    public function __construct(
        QRCodeRepository $QRCodeRepository,
        ScanRepository $scanRepository
    ) {
        $this->QRCodeRepository = $QRCodeRepository;
        $this->scanRepository = $scanRepository;
    }

    public function index()
    {
        $codes = $this->QRCodeRepository->all();

        $account_id = wechat_id();

        $type = !empty(request('type')) ? request('type') : self::QRCode_TYPE_FOREVER;

        $forever_count = $this->QRCodeRepository->findWhere(['account_id' => $account_id, 'type' => self::QRCode_TYPE_FOREVER])->count();

        $temporary_count = $this->QRCodeRepository->findWhere(['account_id' => $account_id, 'type' => self::QRCode_TYPE_TEMPORARY])->count();



        return Admin::content(function (Content $content) use ($codes, $type, $forever_count, $temporary_count) {
            $content->description('二维码列表');

            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '二维码管理', 'url' => 'wechat/QRCode','no-pjax'=>1],
                ['text' => '二维码列表', 'url' => 'wechat/QRCode','no-pjax'=>1]

            );
            $content->body(view('Wechat::QRCode.index', compact('codes', 'type', 'forever_count', 'temporary_count')));
        });
    }

    public function apiQRCodes()
    {
        $account_id = wechat_id();
        $where = [];
        $where['account_id'] = $account_id;
        $page = !empty(request('page')) ? request('page') : 1;
        $pageSize = !empty(request('pageSize')) ? request('pageSize') : 1;

        if (!empty(request('key'))) {
            $where['name'] = ['like', '%'.request('key').'%'];
        }
        if (empty(request('type')) || self::QRCode_TYPE_FOREVER == request('type')) {
            $where['type'] = self::QRCode_TYPE_FOREVER;
        } elseif (self::QRCode_TYPE_TEMPORARY == request('type')) {
            $where['type'] = self::QRCode_TYPE_TEMPORARY;
        }
        $codes = $this->QRCodeRepository->getQRCodesPaginated($where, $pageSize);

        return $this->api(true, 200, '', $codes);
    }

    public function Scans()
    {
//        dd($this->scanRepository->all());
        $ticket = !empty(request('ticket')) ? request('ticket') : '';
        $type = !empty(request('type')) ? request('type') : '';

        $AllCount = $this->scanRepository->getScansPaginated(['ticket' => $ticket], 0)->count();

        $DEFAULT_SCANS_Count = $this->scanRepository->getScansPaginated(['ticket' => $ticket, 'type' => self::DEFAULT_SCANS], 0)->count();

        $FOLLOW_SCANS_Count = $this->scanRepository->getScansPaginated(['ticket' => $ticket, 'type' => self::FOLLOW_SCANS], 0)->count();

        return Admin::content(function (Content $content) use ($ticket, $type, $AllCount, $DEFAULT_SCANS_Count, $FOLLOW_SCANS_Count) {
            $content->description('扫码统计');

            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '二维码管理', 'url' => 'wechat/QRCode','no-pjax'=>1],
                ['text' => '二维码列表', 'url' => 'wechat/QRCode','no-pjax'=>1],
                ['text' => '扫码统计']

            );
            $content->body(view('Wechat::QRCode.scans.index', compact('ticket', 'type', 'AllCount', 'DEFAULT_SCANS_Count', 'FOLLOW_SCANS_Count')));
        });
    }

    public function apiScans()
    {
        $where = [];
        $time = [];
        $ticket = !empty(request('ticket')) ? request('ticket') : '';

        $type = !empty(request('type')) ? request('type') : '';
        if (!empty($type)) {
            $where['type'] = intval($type);
        }
        $where['ticket'] = $ticket;
        $page = !empty(request('page')) ? request('page') : 1;
        $pageSize = !empty(request('pageSize')) ? request('pageSize') : 1;

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

        $scans = $this->scanRepository->getScansPaginated($where, $pageSize, $time);

        return $this->api(true, 200, '', $scans);
    }

    public function create()
    {
        
        return Admin::content(function (Content $content) {
            $content->description('创建二维码');

            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '二维码管理', 'url' => 'wechat/QRCode','no-pjax'=>1],
                ['text' => '二维码列表', 'url' => 'wechat/QRCode','no-pjax'=>1],
                ['text' => '创建二维码']

            );
            $content->body(view('Wechat::QRCode.create'));
        });
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        $type = !empty(request('type')) ? request('type') : 2;
        $expire_seconds = !empty(request('expire_seconds')) ? request('expire_seconds') : 2592000;
        $input['account_id'] = wechat_id();

        if (self::QRCode_TYPE_TEMPORARY == $type) {
            $num = $this->QRCodeRepository->findWhere(['type' => self::QRCode_TYPE_TEMPORARY, 'account_id' => $input['account_id']])->count();
            $scene_id = 100000 + $num;
            $data['scene_id'] = $scene_id;
            $data['expire_seconds'] = intval($expire_seconds);
            $res = QRCodeService::storeTemporary($data);
            if (isset($res->url) && !empty($res->url)) {
                $input['url'] = $res->url;
                $input['ticket'] = $res->ticket;
                $input['qr_code_url'] = $res->qr_code_url;
                $input['scene_id'] = $data['scene_id'];
                $input['created_at'] = date('Y-m-d H:i:s', Carbon::now()->timestamp);
                $input['expire_time'] = date('Y-m-d H:i:s', Carbon::now()->timestamp + intval($expire_seconds));
                if($input['key']==null) $input['key']='';
                $this->QRCodeRepository->create($input);
                return $this->api(true, 200, '创建临时二维码成功', []);
            }
        }

        if (self::QRCode_TYPE_FOREVER == $type) {
            $num = $this->QRCodeRepository->findWhere(['type' => self::QRCode_TYPE_FOREVER, 'account_id' => $input['account_id']])->count();
            $scene_str = "$input[scene_str]".'_'.$num;
            $data['scene_id'] = $scene_str;
            $res = QRCodeService::storeForever($data);
            if (isset($res->ticket) && isset($res->qr_code_url)) {
                $input['url'] = $res->url;
                $input['ticket'] = $res->ticket;
                $input['qr_code_url'] = $res->qr_code_url;
                $input['scene_str'] = $scene_str;
                if($input['key']==null) $input['key']='';
                $this->QRCodeRepository->create($input);

                return $this->api(true, 200, '创建永久二维码成功', []);
            }
        }

        return $this->api(false, 400, '创建二维码失败', []);
    }

    public function edit($id)
    {

        $data = $this->QRCodeRepository->find($id);

        return Admin::content(function (Content $content) use ($id, $data) {

            $content->description('编辑二维码');

            if(wechat_name()){
                $content->header(wechat_name());
            }

            $content->breadcrumb(
                ['text' => '微信管理', 'url' => 'wechat','no-pjax'=>1],
                ['text' => '二维码管理', 'url' => 'wechat/QRCode','no-pjax'=>1],
                ['text' => '二维码列表', 'url' => 'wechat/QRCode','no-pjax'=>1],
                ['text' => '编辑二维码']

            );

            $content->body(view('Wechat::QRCode.edit', compact('id', 'data')));

        });

    }

    public function update($id)
    {
        $data = request()->except('_token');
        $key = !empty(request('key')) ? request('key') : '';
        $name = !empty(request('name')) ? request('name') : '';
        $this->QRCodeRepository->update(['key' => $key, 'name' => $name], $id);

        return $this->api(true, 200, '', []);
    }

    public function apiEdit($id)
    {
        $data = $this->QRCodeRepository->find($id);

        return $this->api(true, 200, '', $data);
    }

    public function destroy($id)
    {
        $this->QRCodeRepository->delete($id);

        return $this->api(true, 200, '', []);
    }
}
