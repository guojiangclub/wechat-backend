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

use GuoJiangClub\Component\User\Models\UserBind;
use iBrand\Wechat\Backend\Facades\CardService;
use iBrand\Wechat\Backend\Facades\FanService;
use iBrand\Wechat\Backend\Facades\MessageService;
use iBrand\Wechat\Backend\Models\Account;
use iBrand\Wechat\Backend\Repository\AccountRepository;
use iBrand\Wechat\Backend\Repository\CardCodeRepository;
use iBrand\Wechat\Backend\Repository\FanRepository;
use iBrand\Wechat\Backend\Repository\QRCodeRepository;
use iBrand\Wechat\Backend\Repository\ScanRepository;
use Illuminate\Http\Request;
use GuoJiangClub\Component\Point\Repository\PointRepository;
use GuoJiangClub\Component\User\Repository\UserRepository;
use GuoJiangClub\Component\Balance\BalanceRepository;

/**
 * 回调事件处理.
 */
class CallBackEventController extends Controller
{
	const DEFAULT_SCANS = 2;  //扫描
	const FOLLOW_SCANS  = 1;  //关注

	protected $accountRepository;

	protected $cardCodeRepository;

	protected $scanRepository;

	protected $QRCodeRepository;

	protected $fanRepository;

	protected $pointRepository;

	protected $userRepository;

	protected $balanceRepository;

	public function __construct(
		AccountRepository $accountRepository,
		CardCodeRepository $cardCodeRepository,
		ScanRepository $scanRepository,
		QRCodeRepository $QRCodeRepository,
		FanRepository $fanRepository,
		PointRepository $pointRepository,
		UserRepository $userRepository,
		BalanceRepository $balanceRepository
	)
	{
		$this->accountRepository  = $accountRepository;
		$this->cardCodeRepository = $cardCodeRepository;
		$this->scanRepository     = $scanRepository;
		$this->QRCodeRepository   = $QRCodeRepository;
		$this->fanRepository      = $fanRepository;
		$this->pointRepository    = $pointRepository;
		$this->userRepository     = $userRepository;
		$this->balanceRepository  = $balanceRepository;
	}

	// 事件处理
	public function event()
	{
		$input = request()->all();
		\Log::info($input);
		$account = Account::where('app_id', $input['app_id'])->first();
		if (!isset($account->id)) {
			return [];
		}
		$accountId  = $account->id;
		$event_type = $input['event_type'];
		$eventData  = $input;
		switch ($input['event_type']) {
			// 关注事件处理
			case 'subscribe':
				unset($input['event_type']);
				$openid = $input['openid'];
				$info   = FanService::getFansInfo(["$openid"], $input['app_id']);
				if (isset($info->user_info_list) && count($info->user_info_list) > 0) {
					foreach ($info->user_info_list as $item) {
						$item               = FanService::formatFromWeChat(collect($item)->toArray());
						$item['account_id'] = $accountId;
						$item['tagid_list'] = str_replace('[', ',', $item['tagid_list']);
						$item['tagid_list'] = str_replace(']', ',', $item['tagid_list']);
//                        if ($user = UserBind::where(['type' => 'wechat', 'open_id' => $item['openid']])->first()) {
//                            $item['user_id'] = $user->user_id;
//                        }
						$this->fanRepository->getIdByOpenid($accountId, $item['openid'], $item);
					}
				}

				event('user.subscribe.official_account', [$eventData]);

				$input['type'] = self::FOLLOW_SCANS;
				if (!empty($input['ticket'])) {
					$code = $this->QRCodeRepository->findWhere(['ticket' => $input['ticket']])->first();
					if (isset($code->name)) {
						$input['name'] = $code->name;
						$this->scanRepository->create($input);
					}
				}

				if (false !== strpos($input['key'], 'wechat_scan_login')) {
					event('ibrandcc.wechat.login', [$input, $event_type, $info]);

					return;
				}

				if (false !== strpos($input['key'], 'shop_id')) {
					event('ibrand.wanyou.clerk.bind', [$input, $info]);

					return;
				}

				if (false !== strpos($input['key'], 'clerk_bind')) {
					event('st.clerk.scan.bind', [$input, $info]);

					return;
				}

				//会员门店扫描
				$key = $input['key'];
				if (substr($key, 8, 10) == 'O2O_shop##') {
					$this->userShopScan($input['key'], $openid, $input['app_id']);
				}

				$key_name = '关注自动回复';
				if (!empty($input['key'])) {
					$key_name = $input['key'];
					$key_str  = str_replace("qrscene_", '', $key);
					if (is_numeric($key_str)) {
						$qr = $this->QRCodeRepository->findWhere(['scene_id' => $key_str])->first();
					} else {
						$qr = $this->QRCodeRepository->findWhere(['scene_str' => $key_str])->first();
					}
					$key_name = isset($qr->key) && !empty($qr->key) ? $qr->key : '关注自动回复';
				}

				return MessageService::CallBack($accountId, $key_name, $input['app_id'], $openid);
				break;
			// 取消关注事件处理
			case 'unsubscribe':
				event('user.unsubscribe.official_account', [$eventData]);
				//$this->fanRepository->deleteWhere(['account_id' => $accountId, 'openid' => $input['openid']]);

				break;
			// 点击CLICK事件处理
			case 'CLICK':
				if ('客服' == $input['key']) {
					if ($kf_account = MessageService::getStaffOnLines([], $input['app_id'])) {
						MessageService::getStaffSession(['kf_account' => $kf_account, 'openid' => $input['open_id']], $input['app_id']);
					} else {
						return MessageService::CallBack($accountId, '无客服在线', $input['app_id'], $input['open_id']);
					}
				}

				return MessageService::CallBack($accountId, $input['key'], $input['app_id'], $input['open_id']);
				break;
			// 点击扫描事件处理
			case 'SCAN':
				unset($input['event_type']);
				$code          = $this->QRCodeRepository->findWhere(['ticket' => $input['ticket']])->first();
				$input['type'] = self::DEFAULT_SCANS;
				if (isset($code->name)) {
					$input['name'] = $code->name;
				}
				$this->scanRepository->create($input);
				$keyword = isset($code->key) ? $code->key : '';

				//会员门店扫描
				$key = $input['key'];
				if (substr($key, 0, 10) == 'O2O_shop##') {
					$this->userShopScan($input['key'], $input['openid'], $input['app_id']);
					break;
				}

				if (false !== strpos($key, 'wechat_scan_login')) {
					event('ibrandcc.wechat.login', [$input, $event_type, null]);

					return;
				}

				if (false !== strpos($input['key'], 'shop_id')) {
					$openid = $input['openid'];
					$info   = FanService::getFansInfo(["$openid"], $input['app_id']);
					event('ibrand.wanyou.clerk.bind', [$input, $info]);

					return;
				}

				if (false !== strpos($input['key'], 'clerk_bind')) {
					$openid = $input['openid'];
					$info   = FanService::getFansInfo(["$openid"], $input['app_id']);
					event('st.clerk.scan.bind', [$input, $info]);

					return;
				}

				event('user.scan.official_account', [$eventData]);

				return MessageService::CallBack($accountId, $keyword, $input['app_id'], $input['openid']);
				break;
			// 领取卡券件处理
			case 'user_get_card':
				$this->user_get_card($input);
				break;
			//核销Code
			case 'user_consume_card':
				break;
			//删除会员卡
			case 'user_del_card':
				$this->user_del_card($input);
				break;
//            点击会员卡
			case'user_view_card':
				$this->user_view_card($input);
				break;
			case 'card_pass_check':
				break;
			case 'card_not_pass_check':
				break;
			default:
				return '';
				break;
		}
	}

	//领取卡券事件
	protected function user_get_card($input)
	{
		unset($input['event_type']);
		$input['appid']  = $input['app_id'];
		$input['openid'] = $input['open_id'];
		unset($input['app_id']);
		unset($input['open_id']);
		\Log::info($input);
		if ($user = UserBind::where(['type' => 'wechat', 'open_id' => $input['openid']])->first()) {
			$input['user_id'] = $user->user_id;
		};

		return $this->cardCodeRepository->create($input);
	}

	// 点击会员卡
	protected function user_view_card($input)
	{
		if ($user = UserBind::where(['open_id' => $input['open_id']])->first()) {
			$user_id = $user->user_id;
			if (!empty($user_id)) {
				$pointValid  = $this->pointRepository->getSumPointValid($user_id, $type = null);
				$userGroup   = $this->userRepository->with('group')->find($user_id);
				$amountCount = $this->balanceRepository->getSum($user_id) / 100;
				$data        = [
					'card_id'             => $input['card_id'],
					'code'                => $input['code'],
					'custom_field_value1' => empty($pointValid) ? 0 : $pointValid,
					'custom_field_value2' => empty($amountCount) ? 0 : $amountCount,
					'custom_field_value3' => empty($userGroup) ? 0 : $userGroup->group->grade,
				];
				$res         = CardService::membershipUpdate($data, $input['app_id']);
			}
		};
	}

	// 删除会员卡
	protected function user_del_card($input)
	{
		\Log::info('del');
		$this->cardCodeRepository->deleteWhere(['openid' => $input['open_id'], 'code' => $input['code']]);
	}
}
