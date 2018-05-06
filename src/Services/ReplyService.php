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

use Cache;
use iBrand\Wechat\Backend\Repository\ReplyRepository;

/**
 * 回复服务.
 */
class ReplyService
{
    /**
     * eventService.
     *
     * @var EventService
     */
    private $eventService;

    /**
     * replyRepository.
     */
    private $replyRepository;

    public function __construct(EventService $eventService, ReplyRepository $replyRepository)
    {
        $this->eventService = $eventService;

        $this->replyRepository = $replyRepository;
    }

    /**
     * 解析一个事件回复.
     *
     * @return array
     */
    public function resolveReply($reply)
    {
        $eventService = $this->eventService;

        $reply['content'] = array_map(function ($eventId) use ($eventService) {
            return $eventService->eventToMaterial($eventId);
        }, $reply['content']);

        return $reply;
    }

    /**
     * 解析多个事件回复.
     *
     * @param array $replies replies
     *
     * @return array
     */
    public function resolveReplies($replies)
    {
        $replies = $replies->toArray();

        return array_map(function ($reply) {
            return $this->resolveReply($reply);
        }, $replies);
    }

    /**
     * 重建回复缓存.
     *
     * @param int $accountId 公众号ID
     */
    public function rebuildReplyCache($accountId)
    {
        $replies = $this->replyRepository->all($accountId);

        if (empty($replies)) {
            Cache::forget('replies_'.$accountId);
        }

        $caches = [];

        foreach ($replies as $reply) {
            foreach ($reply['trigger_keywords'] as $keyword) {
                $caches[$keyword]['type'] = $reply['trigger_type'];
                $caches[$keyword]['content'] = $reply['content'];
            }
        }

        Cache::forever('replies_'.$accountId, $caches);
    }
}
