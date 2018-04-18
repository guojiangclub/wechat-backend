<?php

namespace iBrand\Wechat\Backend\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function api($status = true, $code = 200, $message = '', $data = array())
    {
        return response()->json(
            ['status' => $status
                , 'code' => $code
                , 'message' => $message
                , 'data' => $data]);
    }
}
