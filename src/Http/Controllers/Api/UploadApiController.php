<?php
namespace iBrand\Wechat\Backend\Http\Controllers\Api;

use iBrand\Wechat\Backend\Services\AccountService;
use Illuminate\Http\Request;
use iBrand\Wechat\Backend\Models\Account;

use App\Http\Controllers\Controller;
use iBrand\Wechat\Backend\Repository\MaterialRepository;
use Exception;
use iBrand\Wechat\Backend\Facades\MaterialService;




class UploadApiController extends Controller
{

    /**
     * 识别 key.
     */
    const UPLOAD_KEY = 'file';

    protected $materialRepository;

    protected $account;

    /**
     * UploadController constructor.
     * @param MaterialRepository $materialRepository
     */
    public function __construct(
        MaterialRepository $materialRepository

    )
    {
        $this->materialRepository =$materialRepository;


    }





    /**
     * 上传文件.
     *
     * @return json
     */
    public function index(Request $request)
    {

        $file = $request->file('file');

        if (!$file->getMimeType()) {
            throw new Exception('file type error.', 422);
        }

        if (!$request->hasFile(self::UPLOAD_KEY)) {
            throw new Exception('no file found.', 422);
        }

        $extension = $file->getClientOriginalExtension();

        $type = $file->getMimeType();

        // 后加代码
        if(preg_match("/^image/",$type)){
            $type="image";
            $mime = 'image/'.$extension;
        }elseif (preg_match("/^video/",$type)){
            $type="video";
            $mime = 'video/'.$extension;
        }elseif (preg_match("/^audio/",$type)){
            $type="audio";
            $mime = 'audio/'.$extension;
        }

        $file = $request->file(self::UPLOAD_KEY);

        $filesize = $file->getSize();

        $ext = $this->checkMime($mime, $type);

        $this->checkSize($filesize, $type);

        $originalName = $file->getClientOriginalName();

        $filename = md5_file($file->getRealpath()).'.'.$ext;

        $dir = config('wechat-material.'.$type.'.storage_path');


        is_dir($dir) || mkdir($dir, 0755, true);

        if (!file_exists($dir.$filename)) {
            $file->move($dir, $filename);
        }

        if ('image' == $type) {
            $app_id=settings('wechat_app_id');
            $res=Account::where(['app_id'=>$app_id])->first();
            if(empty($app_id)||empty($res)){
                return response()->json(
                    ['status' => false
                        , 'code' => 405
                        , 'message' => '未设置微信主公众号或公众号未授权'
                        , 'data' => []]);
            }

            $imagePath= $filename;

            $account_id=$res->id;

            $resourceUrl = config('app.url').'/storage'.config('wechat-material.image.prefix').'/'.$imagePath;

            $Path=base_path().'/storage/app/public'.config('wechat-material.image.prefix').'/'.$imagePath;

            $image=json_decode(MaterialService::postRemoteImage($Path,$res->app_id));

            if(!empty($image->url)&&!empty($image->media_id)){
                return $this->materialRepository->storeImage($account_id, $resourceUrl,$image->media_id,$image->url);
            }

//            return $this->saveImageMaterial($filename,$res->id);
        }

        $response = [
            'originalName' => $originalName,
            'name' => $originalName,
            'size' => $filesize,
            'type' => ".{$ext}",
            'path' => $filename,
            'url' => config('wechat-material.'.$type.'.prefix').'/'.$filename,
            'state' => 'SUCCESS',
        ];

        return json_encode($response);
    }

    /**
     * 检查大小.
     *
     * @param int    $size
     * @param string $type 上传文件类型
     *
     * @throws Exception If too big.
     */
    protected function checkSize($size, $type)
    {
        if ($size > config('wechat-material.'.$type.'.upload_max_size')) {
            throw new Exception('To big file.', 422);
        }
    }

    /**
     * 检测Mime类型.
     *
     * @param string $mime mime类型
     * @param string $type 文件上传类型
     *
     * @return bool
     */
    protected function checkMime($mime, $type)
    {
        $allowTypes = config('wechat-material.'.$type.'.allow_types');
        if (!$ext = array_search($mime, $allowTypes)) {
            throw new Exception('Error file type', 422);
        }

        return $ext;
    }



    /**
     * 保存图片到素材.
     *
     * @param string $imagePath 图片路径
     *
     * @return Response
     */
    protected function saveImageMaterial($imagePath,$account_id)
    {
        $resourceUrl = config('app.url').'/storage'.config('wechat-material.image.prefix').'/'.$imagePath;

        $Path=base_path().'/storage/app/public'.config('wechat-material.image.prefix').'/'.$imagePath;

//        $account_id = wechat_id();

        $image=json_decode(MaterialService::postRemoteImage($Path));

        if(!empty($image->url)&&!empty($image->media_id)){
            return $this->materialRepository->storeImage($account_id, $resourceUrl,$image->media_id,$image->url);
        }

    }
























}