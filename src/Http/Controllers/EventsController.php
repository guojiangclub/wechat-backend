<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Http\Controllers;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use iBrand\Wechat\Backend\Repository\EventRepository;
use iBrand\Wechat\Backend\Repository\MaterialRepository;
use Illuminate\Http\Request;

/**
 *自动回复事件管理.
 */
class EventsController extends Controller
{
    const Material_TYPE_IMAGE = 2;
    const Material_TYPE_ViDEO = 4;
    const Material_TYPE_VOICE = 5;
    const Material_TYPE_ARTICLE = 3;
    const Material_TYPE_TEXT = 1;
    const CARD_TEXT = 6;

    protected $eventRepository;

    protected $materialRepository;

    public function __construct(EventRepository $eventRepository,
       MaterialRepository $materialRepository
    ) {
        $this->eventRepository = $eventRepository;
        $this->materialRepository = $materialRepository;
    }

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->body(view('Wechat::events.index'));
        });
    }

    public function apiEvents()
    {
        $account_id = wechat_id();
        $where = [];
        $where['account_id'] = $account_id;
        $page = !empty(request('page')) ? request('page') : 1;
        $pageSize = !empty(request('pageSize')) ? request('pageSize') : 1;

        if (!empty(request('key'))) {
            $where['key'] = ['like', '%'.request('key').'%'];
        }

        if (empty(request('m_type')) || self::Material_TYPE_TEXT == request('m_type')) {
            $where['material_type'] = 'text';
            $where['type'] = 'material';
            if (!empty(request('key'))) {
                $this->pageKeys(request('key'), $where, $page, $pageSize);
            }
            $events = $this->eventRepository->getEventsPaginated($where, $pageSize);
            $events->data = $this->getValue('text', $events);
        } elseif (self::Material_TYPE_ViDEO == request('m_type')) {
            $where['material_type'] = 'video';
            $where['type'] = 'material';
            if (!empty(request('key'))) {
                $this->pageKeys(request('key'), $where, $page, $pageSize);
            }
            $events = $this->eventRepository->getEventsPaginated($where, $pageSize);
            $events->data = $this->getValue('video', $events);
        } elseif (self::Material_TYPE_VOICE == request('m_type')) {
            $where['material_type'] = 'voice';
            $where['type'] = 'material';
            if (!empty(request('key'))) {
                $this->pageKeys(request('key'), $where, $page, $pageSize);
            }
            $events = $this->eventRepository->getEventsPaginated($where, $pageSize);
            $events->data = $this->getValue('voice', $events);
        } elseif (self::Material_TYPE_ARTICLE == request('m_type')) {
            $where['material_type'] = 'article';
            $where['type'] = 'material';
            if (!empty(request('key'))) {
                $this->pageKeys(request('key'), $where, $page, $pageSize);
            }
            $events = $this->eventRepository->getEventsPaginated($where, $pageSize);
            $events->data = $this->getValue('article', $events);
        } elseif (self::Material_TYPE_IMAGE == request('m_type')) {
            $where['material_type'] = 'image';
            $where['type'] = 'material';
            if (!empty(request('key'))) {
                $this->pageKeys(request('key'), $where, $page, $pageSize);
            }
            $events = $this->eventRepository->getEventsPaginated($where, $pageSize);
            $events->data = $this->getValue('image', $events);
        } elseif (self::CARD_TEXT == request('m_type')) {
            $where['type'] = 'addon';
            $where['material_type'] = 'text';
            if (!empty(request('key'))) {
                $this->pageKeys(request('key'), $where, $page, $pageSize);
            }
            $events = $this->eventRepository->getEventsPaginated($where, $pageSize);
            $events->data = $events;
        }

        return $this->api(true, 200, '', $events);
    }

    public function create()
    {
        $m_type = !empty(request('m_type')) ? request('m_type') : 0;

        return Admin::content(function (Content $content) use ($m_type) {
            $content->body(view('Wechat::events.includes.create.index', compact('m_type')));
        });
    }

    //创建
    public function store()
    {
        $data = request()->except('_token');
        $account_id = wechat_id();
        $m_type = !empty(request('m_type')) ? request('m_type') : 0;
        $rule = request('rule');
        $key = !empty(request('key')) ? request('key') : [];
        $type = request('type');
        if (count($key) > 1) {
            $keys = implode(' ', $key);
        } else {
            $keys = $key[0];
        }

        if (self::CARD_TEXT !== intval(request('m_type'))) {
            $res = $this->eventRepository->create(['key' => $keys, 'account_id' => $account_id, 'type' => 'material', 'material_type' => $type, 'value' => request('material_id'), 'rule' => $rule]);
        } else {
            $res = $this->eventRepository->create(['key' => $keys, 'account_id' => $account_id, 'type' => 'addon', 'material_type' => 'text', 'value' => request('value'), 'rule' => $rule]);
        }

        return $this->api(true, 200, '', $res);
    }

    protected function getValue($type, $events)
    {
        $event = [];
        if (count($events) > 0) {
            foreach ($events as $key => $item) {
                if ('text' === $type && $item->material) {
                    $event[$key] = $item;
                    $event[$key]['value'] = $item->material->content;
                }
                if ('image' === $type && $item->material) {
                    $event[$key] = $item;
                    $event[$key]['value'] = $item->material->source_url;
                }
                if ('video' === $type && $item->material) {
                    $event[$key] = $item;
                    $event[$key]['value'] = $item->material->source_url;
                }
                if ('article' === $type && $item->material) {
                    $event[$key] = $item;
                    $event[$key]['value'] = $item->material->title;
                }
            }

            return $event;
        }
    }

    protected function screenKeyword($data, $key)
    {
        $newData = [];
        if (count($data) > 0) {
            foreach ($data as $k => $item) {
                $keyArr = explode(' ', $item->key);
                if (in_array($key, $keyArr)) {
                    $newData[] = $item;
                }
            }

            return $newData;
        }

        return [];
    }

    public function edit($id)
    {
        $m_type = !empty(request('m_type')) ? request('m_type') : 0;

        return view('Wechat::events.includes.create.index', compact('id', 'm_type'));
    }

    public function apiEdit($id)
    {
        $data = $this->eventRepository->with('material')->find($id);

        return $this->api(true, 200, '', $data);
    }

    public function update($id)
    {
        $data = request()->except('_token');
        $account_id = wechat_id();
        $m_type = !empty(request('m_type')) ? request('m_type') : 0;
        $rule = request('rule');
        $key = !empty(request('key')) ? request('key') : [];
        $type = request('type');
        $material_id = request('material_id');
        if (count($key) > 1) {
            $keys = implode(' ', $key);
        } else {
            $keys = $key[0];
        }

        if (self::CARD_TEXT !== intval(request('m_type'))) {
            $res = $this->eventRepository->update(['key' => $keys, 'account_id' => $account_id, 'type' => 'material', 'material_type' => $type, 'value' => $material_id, 'rule' => $rule], $id);
        } else {
            $res = $this->eventRepository->update(['key' => $keys, 'account_id' => $account_id, 'type' => 'addon', 'material_type' => 'text', 'value' => request('value'), 'rule' => $rule], $id);
        }

        return $this->api(true, 200, '', $res);
    }

    public function destroy($id)
    {
        $this->eventRepository->delete($id);

        return $this->api(true, 200, '', []);
    }

    protected function pageKeys($key, $where, $page, $pageSize)
    {
        $events = $this->eventRepository->getEventsPaginated($where, 0);
        $events_data = $this->screenKeyword($events, $key);
        $events_new_data = collect($events_data);
        $events_new_data = $events_new_data->forPage($page, $pageSize)->all();
        $events_new = collect(['total' => count($events_data), 'per_page' => $pageSize, 'current_page' => intval($page), 'data' => array_values(collect($events_new_data)->toArray())]);

        return $this->api(true, 200, '', $events_new);
    }
}
