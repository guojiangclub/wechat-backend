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

use iBrand\Wechat\Backend\Repository\EventRepository;
use iBrand\Wechat\Backend\Repository\MaterialRepository;

/**
 * 事件服务提供.
 */
class EventService
{
    /**
     * EventRepository.
     */
    private $eventRepository;

    private $materialRepository;

    public function __construct(
        EventRepository $eventRepository,
        MaterialRepository $materialRepository
    ) {
        $this->eventRepository = $eventRepository;
        $this->materialRepository = $materialRepository;
    }
}
