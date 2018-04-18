<?php

namespace iBrand\Wechat\Backend\Platform;

use Arcanedev\LogViewer\Entities\Log;
use GuzzleHttp\Client;

/**
 * 全局通用 AccessToken.
 */
class AccessToken
{
    protected $getTokenUrl;

    /**
     * 应用ID.
     *
     * @var string
     */
    protected $client_id;

    /**
     * 应用secret.
     *
     * @var string
     */
    protected $client_secret;

    /**
     * 缓存类.
     *
     * @var Cache
     */
    protected $cache;

    /**
     * 缓存前缀
     *
     * @var string
     */
    protected $cacheKey = 'wx.api.access_token';

    /**
     * constructor.
     *
     * @param string $appId
     * @param string $appSecret
     */
    public function __construct($tokenUrl, $prefix, $client_id, $client_secret)
    {
        $this->getTokenUrl = $tokenUrl;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->cache = new Cache($prefix);
    }

    /**
     * 缓存 setter.
     *
     * @param Cache $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * 获取Token.
     *
     * @param bool $forceRefresh
     *
     * @return string
     */
    public function getToken($forceRefresh = false)
    {
        $cacheKey = $this->cacheKey;

        $cached = $this->cache->get($cacheKey);

        if ($forceRefresh || empty($cached)) {
            $token = $this->getTokenFromServer();
            $expires_in=isset($token['expires_in'])?$token['expires_in']:2592000;
            if(isset($token['access_token'])){
                $this->cache->set($cacheKey, $token['access_token'], $expires_in - 800);
                return $token['access_token'];
            }else{
                return '';
            }

        }
        return $cached;
    }

    /**
     * Get the access token from API server.
     *
     * @param string $cacheKey
     *
     * @return array|bool
     */
    protected function getTokenFromServer()
    {
        $http = new Http();
        $params = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'client_credentials',
        );

        $token = $http->post($this->getTokenUrl, $params, ['content-type:application/form-data']);

        return json_decode($token, true);

    }


    /**
     * 从微信获取token
     * @param bool $forceRefresh
     * @return mixed|null
     * @throws \Exception
     */

    public function getTokenFromWx($forceRefresh = false)
    {
        $cacheKey = $this->cacheKey;

        $cached = $this->cache->get($cacheKey);

        if ($forceRefresh || empty($cached)) {
            $token = $this->getTokenFromWxServer();

            $this->cache->set($cacheKey, $token['access_token'], $token['expires_in'] - 800);

            return $token['access_token'];
        }
        return $cached;
    }

    public function getTokenFromWxServer()
    {
        $http = new Http();
        $params = array(
            'grant_type' => 'client_credential',
            'appid' => $this->client_id,
            'secret' => $this->client_secret
        );

        $token = $http->get($this->getTokenUrl, $params, ['content-type:application/form-data']);

        return json_decode($token, true);
    }

    /**
     * 从微信获取Ticket
     * @param bool $forceRefresh
     * @return mixed|null
     * @throws \Exception
     */
    public function getTicketFromWx($forceRefresh = false)
    {
        $cacheKey = $this->cacheKey;

        $cached = $this->cache->get($cacheKey);

        if ($forceRefresh || empty($cached)) {
            $ticket = $this->getTicketFromWxServer();

            $this->cache->set($cacheKey, $ticket['ticket'], $ticket['expires_in'] - 800);

            return $ticket['ticket'];
        }
        return $cached;
    }

    public function getTicketFromWxServer()
    {
        $http = new Http();
        $params = array(
            'access_token' => $this->client_secret,
            'type' => 'jsapi'
        );

        $ticket = $http->get($this->getTokenUrl, $params, ['content-type:application/form-data']);

        return json_decode($ticket, true);
    }

}
