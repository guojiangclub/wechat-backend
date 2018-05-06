<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Platform\Utils;

/**
 * Http请求类.
 *
 * from https://github.com/dsyph3r/curl-php/blob/master/lib/Network/Curl/Curl.php
 */
class Http
{
    /**
     * Constants for available HTTP methods.
     */
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';

    /**
     * CURL句柄.
     *
     * @var resource handle
     */
    protected $curl;

    /**
     * Create the cURL resource.
     */
    public function __construct()
    {
        $this->curl = curl_init();
    }

    /**
     * Clean up the cURL handle.
     */
    public function __destruct()
    {
        if (is_resource($this->curl)) {
            curl_close($this->curl);
        }
    }

    /**
     * Get the cURL handle.
     *
     * @return resource cURL handle
     */
    public function getCurl()
    {
        return $this->curl;
    }

    protected function request($url, $method = self::GET, $params = [], $request_header = [])
    {
        $request_header = ['Content-Type' => 'application/x-www-form-urlencoded'];
        if (self::GET === $method || self::DELETE === $method) {
            $url .= (stripos($url, '?') ? '&' : '?').http_build_query($params);
            $params = [];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_header);
        if (self::POST === $method) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    /**
     * make cURL file.
     *
     * @param string $filename
     *
     * @return \CURLFile|string
     */
    protected function createCurlFile($filename)
    {
        if (function_exists('curl_file_create')) {
            return curl_file_create($filename);
        }

        return "@$filename;filename=".basename($filename);
    }

    /**
     * Split the HTTP headers.
     *
     * @param string $rawHeaders
     *
     * @return array
     */
    protected function splitHeaders($rawHeaders)
    {
        $headers = [];

        $lines = explode("\n", trim($rawHeaders));
        $headers['HTTP'] = array_shift($lines);

        foreach ($lines as $h) {
            $h = explode(':', $h, 2);

            if (isset($h[1])) {
                $headers[$h[0]] = trim($h[1]);
            }
        }

        return $headers;
    }

    /**
     * Perform the Curl request.
     *
     * @return array
     */
    protected function doCurl()
    {
        $response = curl_exec($this->curl);

        if (curl_errno($this->curl)) {
            throw new \Exception(curl_error($this->curl), 1);
        }

        $curlInfo = curl_getinfo($this->curl);

        $results = [
                    'curl_info' => $curlInfo,
                    'response' => $response,
                   ];

        return $results;
    }
}
