<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Platform;

use iBrand\Wechat\Backend\Platform\Utils\Http as HttpClient;

/**
 * @method mixed jsonPost($url, $params = array(), $options = array())
 */
class Http extends HttpClient
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
     * token.
     *
     * @var AccessToken
     */
    protected $token;

    /**
     * json请求
     *
     * @var bool
     */
    protected $json = false;

    /**
     * 缓存类.
     *
     * @var Cache
     */
    protected $cache;

    /**
     * constructor.
     *
     * @param AccessToken $token
     */
    public function __construct(AccessToken $token = null)
    {
        $this->token = $token;
        parent::__construct();
    }

    /**
     * 设置请求access_token.
     *
     * @param AccessToken $token
     */
    public function setToken(AccessToken $token)
    {
        $this->token = $token;
    }

    /**
     * Make a HTTP GET request.
     *
     * @param string $url
     * @param array  $params
     * @param array  $options
     *
     * @return array
     */
    public function get($url, $params = [], $options = [])
    {
        return $this->request($url, self::GET, $params, $options);
    }

    /**
     * Make a HTTP POST request.
     *
     * @param string $url
     * @param array  $params
     * @param array  $options
     *
     * @return array
     */
    public function post($url, $params = [], $options = [])
    {
        return $this->request($url, self::POST, $params, $options);
    }

    /**
     * Make a HTTP PUT request.
     *
     * @param string $url
     * @param array  $params
     * @param array  $options
     *
     * @return array
     */
    public function put($url, $params = [], $options = [])
    {
        return $this->request($url, self::PUT, $params, $options);
    }

    /**
     * Make a HTTP PATCH request.
     *
     * @param string $url
     * @param array  $params
     * @param array  $options
     *
     * @return array
     */
    public function patch($url, $params = [], $options = [])
    {
        return $this->request($url, self::PATCH, $params, $options);
    }

    /**
     * Make a HTTP DELETE request.
     *
     * @param string $url
     * @param array  $params
     * @param array  $options
     *
     * @return array
     */
    public function delete($url, $params = [], $options = [])
    {
        return $this->request($url, self::DELETE, $params, $options);
    }

    /**
     * 发起一个HTTP/HTTPS的请求
     *
     * @param string $url     接口的URL
     * @param string $method  请求类型   GET | POST
     * @param array  $params  接口参数
     * @param array  $options 其它选项
     * @param int    $retry   重试次数
     *
     * @return array | boolean
     */
    public function request($url, $method = self::GET, $params = [], $options = [], $retry = 1)
    {
        if ($this->token) {
            // clear repeat token
            $url = preg_replace('/[\?&]access_token=.*/i', '', $url);
            $url .= (stripos($url, '?') ? '&' : '?').'access_token='.$this->token->getToken();
        }

        $method = strtoupper($method);

        /*if ($this->json) {
            $options['json'] = true;
        }*/

        /*$options[] = 'Authorization:Bearer ' . $this->token->getToken();*/

        $response = parent::request($url, $method, $params, $options);

        return $response;
    }

    /**
     * 魔术调用.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (0 === stripos($method, 'json')) {
            $method = strtolower(substr($method, 4));
            $this->json = true;
        }

        $result = call_user_func_array([$this, $method], $args);

        return $result;
    }
}
