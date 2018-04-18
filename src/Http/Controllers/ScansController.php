<?php
namespace iBrand\Wechat\Backend\Http\Controllers;

use iBrand\Wechat\Backend\Repository\ScanRepository;

use Illuminate\Http\Request;
use iBrand\Wechat\Backend\Facades\QRCodeService;
/**
 * 扫描统计.
 *
 */
class ScansController extends Controller
{


    const DEFAULT_SCANS=2;  //扫描
    const FOLLOW_SCANS=1;  //关注

    protected $scanRepository;

    public function __construct(
        ScanRepository $scanRepository
    )
    {
        $this->scanRepository = $scanRepository;
    }


    public function index(){

        $type=!empty(request('type'))?request('type'):'';

        
        $app_id=wechat_app_id();

//        dd($this->scanRepository->getScansPaginated([],100));

        $AllCount= $this->scanRepository->getScansPaginated(['app_id'=>$app_id],0)->count();

        $DEFAULT_SCANS_Count= $this->scanRepository->getScansPaginated(['app_id'=>$app_id,'type'=>self::DEFAULT_SCANS],0)->count();

        $FOLLOW_SCANS_Count= $this->scanRepository->getScansPaginated(['app_id'=>$app_id,'type'=>self::FOLLOW_SCANS],0)->count();

        return view('Wechat::scans.index',compact('type','AllCount','DEFAULT_SCANS_Count','FOLLOW_SCANS_Count'));
    }


    public function apiScans(){

        $where=[];
        $time=[];
        $type=!empty(request('type'))?request('type'):'';

        if(!empty($type)){
            $where['type']=intval($type);
        }

        $where['app_id']=wechat_app_id();

        if (!empty(request('keyword'))) {
            $where['name'] = ['like', '%' . request('keyword') . '%'];
        }

        $page=!empty(request('page'))?request('page'):1;
        $pageSize=!empty(request('pageSize'))?request('pageSize'):1;

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

        $scans= $this->scanRepository->getScansPaginated($where,$pageSize,$time);

        return $this->api(true,200,'',$scans);
    }








}
