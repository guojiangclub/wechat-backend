<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Services;

use iBrand\Wechat\Backend\Repository\FanReportRepository;
use iBrand\Wechat\Backend\Repository\FanRepository;

/**
 * 粉丝与公众号交互的数据报表服务
 */
class FanReportService
{
    /**
     * repository.
     */
    private $fanRepository;

    /**
     * repository.
     */
    private $fanReportRepository;

    /**
     * construct.
     */
    public function __construct(FanRepository $fanRepository, FanReportRepository $fanReportRepository)
    {
        $this->fanRepository = $fanRepository;
        $this->fanReportRepository = $fanReportRepository;
    }

    /**
     * 粉丝活跃度+1, 同时在fan_reports表中增加记录.
     *
     * @param int    $accountId AccountID
     * @param string $openId    OpenID
     * @param string $type      操作类型
     *
     * @return bool
     */
    public function setLiveness($accountId, $openId, $type)
    {
        /*
         * 1 粉丝活跃度+1
         */
        $this->fanRepository->updateLiveness(['account_id' => $accountId, 'openid' => $openId]);

        /*
         * 2 在fan_reports表中增加记录
         */
        $this->fanReportRepository->store(['account_id' => $accountId, 'openid' => $openId, 'type' => $type]);
    }
}
