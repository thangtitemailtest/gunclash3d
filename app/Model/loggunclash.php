<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\player;
use DateTime;

class loggunclash extends Model
{
	protected $table = "loggunclash";
	public $timestamps = false;

	public function insertLogLogin($deviceid, $country)
	{
		$loggunclash = new loggunclash();
		$loggunclash->deviceid = $deviceid;
		$loggunclash->country = $country;
		$loggunclash->eventname = 'login';
		$loggunclash->save();

		return 1;
	}

	public function getColumn(){
		$eventname = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());

		return $eventname;
	}

	public function insertLogApi($input, $content_get)
	{
		$eventname = isset($input['eventname']) ? $input['eventname'] : "";
		$deviceid = isset($input['deviceid']) ? $input['deviceid'] : "";
		$level = isset($input['level']) ? $input['level'] : 0;
		$sku = isset($input['sku']) ? $input['sku'] : "";
		$skinid = isset($input['skinid']) ? $input['skinid'] : 0;
		$gunid = isset($input['gunid']) ? $input['gunid'] : 0;
		$gunsku = isset($input['gunsku']) ? $input['gunsku'] : "";
		$towerid = isset($input['towerid']) ? $input['towerid'] : 0;
		$towerlevel = isset($input['towerlevel']) ? $input['towerlevel'] : 0;
		$typelevel = isset($input['typelevel']) ? $input['typelevel'] : 0;

		//$content_get = isset($input['content_get']) ? $input['content_get'] : [];
		$powerlevel = isset($content_get['powerlevel']) ? $content_get['powerlevel'] : 0;
		$moneylevel = isset($content_get['moneylevel']) ? $content_get['moneylevel'] : 0;
		$armorlevel = isset($content_get['armorlevel']) ? $content_get['armorlevel'] : 0;
		$c_coin = isset($content_get['c_coin']) ? $content_get['c_coin'] : 0;
		$u_coin = isset($content_get['u_coin']) ? $content_get['u_coin'] : 0;
		$g_coin = isset($content_get['g_coin']) ? $content_get['g_coin'] : 0;
		$total_ads_full = isset($content_get['total_ads_full']) ? $content_get['total_ads_full'] : 0;
		$total_ads_gift = isset($content_get['total_ads_gift']) ? $content_get['total_ads_gift'] : 0;
		$count_level_lose = isset($content_get['count_level_lose']) ? $content_get['count_level_lose'] : 0;
		$count_battle_lose = isset($content_get['count_battle_lose']) ? $content_get['count_battle_lose'] : 0;
		$count_gift_get_money_endgame = isset($content_get['count_gift_get_money_endgame']) ? $content_get['count_gift_get_money_endgame'] : 0;
		$count_gift_get_key = isset($content_get['count_gift_get_key']) ? $content_get['count_gift_get_key'] : 0;
		$count_gift_get_box = isset($content_get['count_gift_get_box']) ? $content_get['count_gift_get_box'] : 0;
		$count_gift_get_money_inskin = isset($content_get['count_gift_get_money_inskin']) ? $content_get['count_gift_get_money_inskin'] : 0;
		$count_gift_upgrade = isset($content_get['count_gift_upgrade']) ? $content_get['count_gift_upgrade'] : 0;
		$country = isset($content_get['country']) ? $content_get['country'] : "";

		$loggunclash = new loggunclash();
		$loggunclash->deviceid = $deviceid;
		$loggunclash->eventname = $eventname;
		$loggunclash->sku = $sku;
		$loggunclash->skinid = $skinid;
		$loggunclash->gunid = $gunid;
		$loggunclash->gunsku = $gunsku;
		$loggunclash->level = $level;
		$loggunclash->powerlevel = $powerlevel;
		$loggunclash->moneylevel = $moneylevel;
		$loggunclash->armorlevel = $armorlevel;
		$loggunclash->c_coin = $c_coin;
		$loggunclash->u_coin = $u_coin;
		$loggunclash->g_coin = $g_coin;
		$loggunclash->total_ads_full = $total_ads_full;
		$loggunclash->total_ads_gift = $total_ads_gift;
		$loggunclash->count_level_lose = $count_level_lose;
		$loggunclash->count_battle_lose = $count_battle_lose;
		$loggunclash->count_gift_get_money_endgame = $count_gift_get_money_endgame;
		$loggunclash->count_gift_get_key = $count_gift_get_key;
		$loggunclash->count_gift_get_box = $count_gift_get_box;
		$loggunclash->count_gift_get_money_inskin = $count_gift_get_money_inskin;
		$loggunclash->count_gift_upgrade = $count_gift_upgrade;
		$loggunclash->towerid = $towerid;
		$loggunclash->towerlevel = $towerlevel;
		$loggunclash->country = $country;
		$loggunclash->typelevel = $typelevel;

		$loggunclash->save();

		// player updatedate
		$player = new player();
		$player->updateDate($deviceid, $country);

		return 1;
	}

	public function SoUserConLaiSauCacLevel($input)
	{
		$log = $this::select('level', 'deviceid')->where('eventname', '=', 'play_level')->where('level', '<', 101);
		$log = $this->checkDate($log, $input);

		return $log->orderBy('deviceid', 'ASC')->orderBy('id', 'DESC');
	}

	public function LocSoTienCuaUser($input)
	{
		$log = $this::select('c_coin', 'level', 'deviceid')->where('eventname', '=', 'win_level');
		$log = $this->checkDate($log, $input);

		return $log->orderBy('deviceid', 'ASC')->orderBy('id', 'ASC');
	}

	public function LocSoNguoiChoiPass($input)
	{
		$log = $this::select('level', 'deviceid')->where('eventname', '=', 'win_level')
			->where('level', '<', 101);
		$log = $this->checkDate($log, $input);

		return $log->orderBy('deviceid', 'ASC')->orderBy('id', 'ASC');
	}

	public function LocSoNguoiChoiLose($input)
	{
		$log = $this::select('level', 'deviceid')->where('eventname', '=', 'lose_level')
			->where('level', '<', 101);
		$log = $this->checkDate($log, $input);

		return $log->orderBy('deviceid', 'ASC')->orderBy('id', 'ASC');
	}

	public function LocSoNguoiChoiStart($input)
	{
		$log = $this::select('level', 'deviceid')->where('eventname', '=', 'play_level')
			->where('level', '<', 101);
		$log = $this->checkDate($log, $input);

		return $log->orderBy('deviceid', 'ASC')->orderBy('id', 'ASC');
	}

	public function LocSoTienNguoiChoiPass($input)
	{
		$log = $this::select('level', 'c_coin')->where('eventname', '=', 'win_level')
			->where('level', '<', 101);
		$log = $this->checkDate($log, $input);

		return $log;
	}

	public function LocSoTienNguoiChoiLose($input)
	{
		$log = $this::select('level', 'c_coin')->where('eventname', '=', 'lose_level')
			->where('level', '<', 101);
		$log = $this->checkDate($log, $input);

		return $log;
	}

	public function QuocGiaCoSoLoginNhieuNhat($input)
	{
		$log = $this::select('country')->where('country', '<>', '');
		$log = $this->checkDate($log, $input);

		return $log->groupBy('deviceid');
	}

	public function LocLevelUserMuaInapp($input)
	{
		$log = $this::select('level')
			->where('eventname', '=', 'buy_inapp')
			->where('level', '<', 101);
		$log = $this->checkDate($log, $input);

		return $log;
	}

	public function LogLogevent($input)
	{
		$log = $this::query();
		$log = $this->checkDate($log, $input);
		if (isset($input['deviceid']) && !empty($input['deviceid'])) {
			$log->where('deviceid', '=', $input['deviceid']);
		}
		if (isset($input['eventname']) && !empty($input['eventname'])) {
			$log->where('eventname', '=', $input['eventname']);
		}

		return $log->orderBy('id', 'DESC');
	}

	public function checkDate($log, $input, $join = '')
	{
		if (!empty($join)) $join .= ".";
		if (isset($input['time']) && !empty($input['time'])) {
			switch ($input['time']) {
				case "week":
					if (isset($input['week']) && !empty($input['week'])) {
						$week = explode('-W', $input['week']);
						$nam = $week[0];
						$tuan = $week[1];
						$dto = new DateTime();
						$dto->setISODate($nam, $tuan);
						$date['week_start'] = $dto->format('Y-m-d');
						$dto->modify('+7 days');
						$date['week_end'] = $dto->format('Y-m-d') . " 00:00:00";

						$date['week_start'] = date('Y-m-d', strtotime($date['week_start'] . " -1 day")) . " 23:59:59";


						$log->where($join . 'createdate', '>', $date['week_start']);
						$log->where($join . 'createdate', '<', $date['week_end']);
					}

					break;
				case "month":
					if (isset($input['month']) && !empty($input['month'])) {
						$date['month_start'] = date('Y-m-d', strtotime('first day of this month', strtotime($input['month'])));
						$date['month_start'] = date('Y-m-d', strtotime($date['month_start'] . " -1 day")) . " 23:59:59";

						$date['month_end'] = date('Y-m-d', strtotime('last day of this month', strtotime($input['month'])));
						$date['month_end'] = date('Y-m-d', strtotime($date['month_end'] . " +1 day")) . " 00:00:00";

						$log->where($join . 'createdate', '>', $date['month_start']);
						$log->where($join . 'createdate', '<', $date['month_end']);
					}

					break;
				case "tuychon":
					if (isset($input['from-date']) && !empty($input['from-date']) && $input['to-date'] && !empty($input['to-date'])) {
						$from = date('Y-m-d', strtotime($input['from-date'] . " -1 day")) . " 23:59:59";
						$to = date('Y-m-d', strtotime($input['to-date'] . " +1 day")) . " 00:00:00";

						$log->where($join . 'createdate', '>', $from);
						$log->where($join . 'createdate', '<', $to);
					}

					break;
				case "homnay":
					$today = date('Y-m-d');
					$from = $today . " 00:00:00";
					$to = $today . " 23:59:59";

					$log->where($join . 'createdate', '>', $from);
					$log->where($join . 'createdate', '<', $to);

					break;
				default :
					break;
			}
		}

		return $log;
	}

	public function testrandom()
	{
		$log = $this::limit(5)->get()->toArray();

		return $log;
	}

}
