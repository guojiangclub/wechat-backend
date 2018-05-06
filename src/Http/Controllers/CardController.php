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

use iBrand\Wechat\Backend\Facades\CardService;
use iBrand\Wechat\Backend\Models\Card;
use iBrand\Wechat\Backend\Models\LandPage;
use iBrand\Wechat\Backend\Repository\CardRepository;
use Illuminate\Http\Request;

/**
 * 卡券管理.
 */
class CardController extends Controller
{
    protected $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function index()
    {
        $card = $this->cardRepository->all();

        return view('Wechat::card.index', compact('card'));
    }

    public function create()
    {
        return view('Wechat::card.create');
    }

    /**
     * 创建会员卡
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');
        $input['especial']['custom_cell1'] = clearCustomerData($input['especial']['custom_cell1']);
        $input['especial'] = clearCustomerData($input['especial']);

        $input['base_info']['date_info']['type'] = 'DATE_TYPE_PERMANENT';
        $input['base_info']['use_custom_code'] = false;
        $input['base_info']['can_give_friend'] = false;
        $input['base_info']['can_share'] = false;

        $input['base_info']['sku']['quantity'] = intval($input['base_info']['sku']['quantity']);
        $input['base_info']['get_limit'] = intval($input['base_info']['get_limit']);
        $input['especial']['supply_bonus'] = boolval($input['especial']['supply_bonus']);
        $input['especial']['supply_balance'] = boolval($input['especial']['supply_balance']);
        $input['especial']['auto_activate'] = false;

        $input['especial']['bonus_rule']['cost_money_unit'] = intval($input['especial']['bonus_rule']['cost_money_unit']);
        $input['especial']['bonus_rule']['increase_bonus'] = intval($input['especial']['bonus_rule']['increase_bonus']);
        $input['especial']['bonus_rule']['reduce_money'] = intval($input['especial']['bonus_rule']['reduce_money']);

        $data['card_type'] = $input['card_type'];
        $data['member_card']['background_pic_url'] = $input['background_pic_url'];
        $data['member_card']['base_info'] = $input['base_info'];
        $data['member_card']['especial'] = $input['especial'];

        $postData['card'] = $data;
        $data = json_encode($postData, JSON_UNESCAPED_UNICODE);
        $res = CardService::createCard($postData);

        if ($res) {
            $this->cardRepository->create(['title' => $input['base_info']['title'], 'data' => $data, 'card_id' => $res->card_id]);

            return $this->api();
        }

        return $this->api(false, 400, '', []);
    }

    public function userGetCard()
    {
    }

//    public function deleteCard($id)
//    {
//        $card = Card::find($id);
//
//        $result = $this->api->deleteCard(['card_id' => $card->card_id]);
//        if($result->errmsg == 'ok')
//        {
//            $card->delete();
//        }
//        return redirect()->back()->withFlashSuccess('卡券已删除');
//    }
//
//
//    /**
//     * 货架
//     */
//    public function landingPage()
//    {
//        $landPage = LandPage::all();
//        return view('store-backend::wechat.landingPage.index', compact('landPage'));
//    }
//
//    /**
//     * 创建货架
//     */
//    public function createLandingPage()
//    {
//        $card = Card::where('status','off')->get();
//        return view('store-backend::wechat.landingPage.create', compact('card'));
//    }
//
//    /**
//     * 保存货架
//     */
//    public function storeLandingPage(Request $request)
//    {
//        $input = $request->except('_token', 'card_id', 'thumb');
//        $cardIds = request('card_id');
//        $thumbs = request('thumbs');
//
//        $cardList = [];
//        foreach ($cardIds as $key => $value) {
//            $cardArr = [];
//            $card = Card::find($value);
//            $cardArr['card_id'] = $card->card_id;
//            $cardArr['thumb_url'] = $thumbs[$key];
//            array_push($cardList, $cardArr);
//        }
//
//        $input['can_share'] = boolval($input['can_share']);
//        $input['card_list'] = $cardList;
//
//        $result = $this->api->createLandPage($input);
//        if($result->errmsg == 'ok')
//        {
//            LandPage::create(['title' => $input['page_title'],
//                'url' => $result->url,
//                'page_id' => $result->page_id,
//                'card_id' => $cardIds]);
//
//            foreach ($cardIds as $key => $value) {
//                $card = Card::find($value);
//                $card->status = 'on';
//                $card->save();
//            }
//
//            $this->ajaxJson();
//        }

//    }
}
