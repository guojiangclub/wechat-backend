<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!function_exists('wechat_platform')) {
    /**
     * Generate the URL to a named route.
     *
     * @param string $name
     * @param array  $parameters
     * @param bool   $absolute
     *
     * @return string
     */
    function wechat_platform()
    {
        return app('wechat.platform');
    }
}

if (!function_exists('wechat_app_id')) {
    function wechat_app_id()
    {
        if (Session::has('account_app_id')) {
            return Session::get('account_app_id');
        }

        return null;
    }
}

if (!function_exists('wechat_id')) {
    function wechat_id()
    {
        if (Session::has('account_id')) {
            return intval(Session::get('account_id'));
        }

        return null;
    }
}

if (!function_exists('wechat_name')) {
    function wechat_name()
    {
        if (Session::has('account_name')) {
            return Session::get('account_name');
        }

        return null;
    }
}

if (!function_exists('wechat_account')) {
    function wechat_account()
    {
        return app('AccountService');
    }
}

/**
 * CURL 获取文件内容
 *
 * 用法同 file_get_contents
 *
 * @param string
 * @param integerr
 * @return string
 */
function curl_get_contents($url, $timeout = 10)
{
    if (!function_exists('curl_init')) {
        throw new \App\Exceptions\GeneralException('CURL not support');
    }

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

    if (defined('WECENTER_CURL_USERAGENT')) {
        curl_setopt($curl, CURLOPT_USERAGENT, WECENTER_CURL_USERAGENT);
    } else {
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/600.7.12 (KHTML, like Gecko) Version/8.0.7 Safari/600.7.12');
    }

    if (substr($url, 0, 8) == 'https://') {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
    }

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

/**
 * 生成随机字符串
 * @param int $length
 * @return string
 */
function generate_random_string($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function export_csv($data, $head, $file_name = '')
{
    set_time_limit(10000);
    ini_set('memory_limit', '300M');

    /*Storage::makeDirectory('public/exports');
     $path=storage_path('app/public/exports/') .$file_name.'.csv';*/

    $path = storage_path('exports') . '/' . $file_name . '.csv';

    $fp = fopen($path, 'w');

    foreach ($head as $i => $v) {
        $head[$i] = mb_convert_encoding($v, 'gbk', 'utf-8');
    }

    fputcsv($fp, $head);

    foreach ($data as $i => $v) {
        $row = [];
        foreach ($v as $key => $value) {
            $row[$key] = mb_convert_encoding($value, 'gbk', 'utf-8');
        }
        fputcsv($fp, $row);
    }
    fclose($fp);

    /*$result = '/storage/exports/' . $file_name . '.csv';*/

    return $path;
}

/**
 * 生成导出文件名
 * @param $prefix
 * @return string
 */
function generate_export_name($prefix)
{
    return $prefix . date('Y_m_d_H_i_s', time()) . '_' . generate_random_string(5);
}

/**
 * 生成导出文件cache名
 * @param $prefix
 * @return string
 */
function generate_export_cache_name($prefix)
{
    return $prefix . time() . '_' . generate_random_string();
}

if (!function_exists('ibrand_count')) {
    function ibrand_count($obj){

        if(is_array($obj)){
            return count($obj);
        }

        if(is_object($obj)){

            return $obj->count();
        }

        if($obj){

            return 1;
        }

        return 0;

    }
}
