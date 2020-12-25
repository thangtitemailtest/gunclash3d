<?php

namespace App\Http\Controllers;

use App\Model\config;
use App\Model\loggunclash_2;
use App\Model\matchlog_2;
use App\Model\player_2;
use App\Model\towerinfo_2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController_2 extends Controller
{
	function getServicelogin(Request $request)
	{
		$param = $request->all();

		$player = new player_2();
		$player_info = $player->insertUser($param);

		$coin = $player_info['coin'];
		$attack = $player_info['attack'];
		$userid = $player_info['userid'];

		$coinlost = 0;
		$level_maintower_lost = 0;
		$level_warriortower_lost = 0;
		$level_herotower_lost = 0;
		$level_defendtower1_lost = 0;
		$level_defendtower2_lost = 0;

		$arr_attack = [];

		$playertower = new towerinfo_2();
		$check_play_tower_info = $playertower->getTowerinfo($userid);
		if (!$check_play_tower_info) {
			$playertower->insertTowerinfo($userid);
			$player_tower_info = $playertower->getTowerinfoArray0();
		} else {
			$player_tower_info = $playertower->getTowerinfoArray($userid);
			$matchlog = new matchlog_2();
			$matchlog_listdataattack = $matchlog->getListDataAttack($userid);
			if ($matchlog_listdataattack) {
				foreach ($matchlog_listdataattack as $item_matchlog) {
					$level_maintower_lost += $item_matchlog->level_maintower_lost;
					$level_warriortower_lost += $item_matchlog->level_warriortower_lost;
					$level_herotower_lost += $item_matchlog->level_herotower_lost;
					$level_defendtower1_lost += $item_matchlog->level_defendtower1_lost;
					$level_defendtower2_lost += $item_matchlog->level_defendtower2_lost;
					$coinlost += $item_matchlog->coin_lost;

					$useridattack = $item_matchlog->useridattack;
					$useridattack_info = $player->getPlayerId($useridattack);
					if ($useridattack_info) {
						$useridattack_login = $player->getUseridLogin($useridattack_info);
						$arr_attack[] = [
							"deviceid" => $useridattack_info->deviceid,
							"name" => $useridattack_info->name,
							"userid" => $useridattack_login['userid'],
							"type" => $useridattack_login['type'],
						];
					}
				}

				$matchlog->updateDataAttack($userid);
			}
			$player_tower_info[0]['levellost'] = $level_maintower_lost;
			$player_tower_info[1]['levellost'] = $level_warriortower_lost;
			$player_tower_info[2]['levellost'] = $level_herotower_lost;
			$player_tower_info[3]['levellost'] = $level_defendtower1_lost;
			$player_tower_info[4]['levellost'] = $level_defendtower2_lost;
		}

		$result['playerbuilding'] = $player_tower_info;
		$result['listattack'] = $arr_attack;
		//$result['attack_userid'] = "";
		//$result['attack_username'] = "";
		$result['currentcoin'] = $this->checkEmptynumber($coin);
		$result['coinlost'] = $this->checkEmptynumber($coinlost);
		$result['attack'] = $this->checkEmptynumber($attack);
		$result['status'] = 1;

		$result = json_encode($result);
		return $result;
	}

	function getServiceupdatemyinfo(Request $request)
	{
		$status = 1;
		$message = '';
		$param = $request->all();
		$userid = isset($param['userid']) ? $param['userid'] : '';
		$player_tower_info = $request->getContent();
		$player_tower_info = urldecode($player_tower_info);
		$player_tower_info = json_decode($player_tower_info, true);
		$player_tower_info_building = $player_tower_info['playerbuilding'];
		$coin = isset($player_tower_info['currentcoin']) ? $player_tower_info['currentcoin'] : 0;
		$attack = isset($player_tower_info['attack']) ? $player_tower_info['attack'] : 0;
		$world = isset($param['world']) ? $param['world'] : 1;
		$attackwarrior = isset($param['attackwarrior']) ? $param['attackwarrior'] : 0;
		$defendwarrior = isset($param['defendwarrior']) ? $param['defendwarrior'] : 0;

		$player = new player_2();
		$userInfo_id = $player->updateUserinfo($userid, $coin, $attack);

		if ($userInfo_id) {
			$towerinfo = new towerinfo_2();
			$towerinfo->updateTowerinfo2($userInfo_id, $player_tower_info_building, $world, $attackwarrior, $defendwarrior);
		} else {
			$message = "Userid not found";
			$status = 0;
		}

		$result['status'] = $status;
		$result['message'] = $message;

		$result = json_encode($result);
		return $result;
	}

	function getServicegetmytowerinfo(Request $request)
	{
		$param = $request->all();
		$userid = isset($param['userid']) ? $param['userid'] : '';

		$status = 1;
		$message = '';

		$player = new player_2();
		$player_info = $player->getPlayer($userid);
		if ($player_info) {
			$coin = $player_info->coin;
			$attack = $player_info->attack;
			$userid_idplayer = $player_info->id;

			$coinlost = 0;
			$level_maintower_lost = 0;
			$level_warriortower_lost = 0;
			$level_herotower_lost = 0;
			$level_defendtower1_lost = 0;
			$level_defendtower2_lost = 0;

			$arr_attack = [];

			$playertower = new towerinfo_2();
			$player_tower_info = $playertower->getTowerinfoArray($userid_idplayer);
			$matchlog = new matchlog_2();
			$matchlog_listdataattack = $matchlog->getListDataAttack($userid_idplayer);
			if ($matchlog_listdataattack) {
				foreach ($matchlog_listdataattack as $item_matchlog) {
					$level_maintower_lost += $item_matchlog->level_maintower_lost;
					$level_warriortower_lost += $item_matchlog->level_warriortower_lost;
					$level_herotower_lost += $item_matchlog->level_herotower_lost;
					$level_defendtower1_lost += $item_matchlog->level_defendtower1_lost;
					$level_defendtower2_lost += $item_matchlog->level_defendtower2_lost;
					$coinlost += $item_matchlog->coin_lost;

					$useridattack = $item_matchlog->useridattack;
					$useridattack_info = $player->getPlayerId($useridattack);
					if ($useridattack_info) {
						$useridattack_login = $player->getUseridLogin($useridattack_info);
						$arr_attack[] = [
							"deviceid" => $useridattack_info->deviceid,
							"name" => $useridattack_info->name,
							"userid" => $useridattack_login['userid'],
							"type" => $useridattack_login['type'],
						];
					}
				}

				$matchlog->updateDataAttack($userid_idplayer);
			}
			$player_tower_info[0]['levellost'] = $level_maintower_lost;
			$player_tower_info[1]['levellost'] = $level_warriortower_lost;
			$player_tower_info[2]['levellost'] = $level_herotower_lost;
			$player_tower_info[3]['levellost'] = $level_defendtower1_lost;
			$player_tower_info[4]['levellost'] = $level_defendtower2_lost;

			$result['playerbuilding'] = $player_tower_info;
			$result['listattack'] = $arr_attack;
			$result['currentcoin'] = $this->checkEmptynumber($coin);
			$result['coinlost'] = $this->checkEmptynumber($coinlost);
			$result['attack'] = $this->checkEmptynumber($attack);
			//$result['attack_userid'] = "";
			//$result['attack_username'] = "";
		} else {
			$message = "userid not found";
			$status = 0;
		}
		$result['status'] = $status;
		$result['message'] = $message;

		$result = json_encode($result);
		return $result;
	}

	function getServicegetotherplayer(Request $request)
	{
		$param = $request->all();
		$userid = isset($param['userid']) ? $param['userid'] : '';

		$status = 1;
		$message = '';
		$player = new player_2();
		$player_info = $player->getPlayer($userid);
		if ($player_info) {
			$attack = empty($player_info->attack) ? 0 : $player_info->attack;
			$userid_idplayer = $player_info->id;
			$sum_win = empty($player_info->sum_win) ? 0 : $player_info->sum_win;
			$sum_lose = empty($player_info->sum_lose) ? 0 : $player_info->sum_lose;

			$towerinfo = new towerinfo_2();
			$result['players'] = [];
			$otherPlayer = $player->getOtherPlayerRandom($userid_idplayer, $attack, $sum_win, $sum_lose);
			if ($otherPlayer) {
				// random
				$key_random = array_rand($otherPlayer, 6);
				// end cmt random
				foreach ($key_random as $item_key_random) {
					$otherPlayer_random = $otherPlayer[$item_key_random];

					$arr = [];

					$userid_other = $otherPlayer_random['id'];
					$userid_other_deviceid = $otherPlayer_random['deviceid'];
					$userid_other_username = $otherPlayer_random['name'];
					$attack_other = $otherPlayer_random['attack'];
					$coin_other = $otherPlayer_random['coin'];
					$otherTowerinfo = $towerinfo->getTowerinfoArray2($userid_other);
					$otherPlayerbuilding = $otherTowerinfo['player_tower_info'];
					$world = $otherTowerinfo['world'];
					$defendwarrior = $otherTowerinfo['defendwarrior'];

					$arr['playerbuilding'] = $otherPlayerbuilding;
					$arr['world'] = $world;
					$arr['defendwarrior'] = $defendwarrior;
					$arr['attack'] = $attack_other;
					$arr['currentcoin'] = $coin_other;
					$arr['otherusername'] = $userid_other_username;
					$arr['otheruserdeviceid'] = $userid_other_deviceid;

					$useridLogin = $player->getUseridLogin($otherPlayer_random, 'arr');
					$arr['otheruserid'] = $useridLogin['userid'];
					$arr['type'] = $useridLogin['type'];

					$result['players'][] = $arr;
				}
			}
		} else {
			$message = "userid not found";
			$status = 0;
		}
		$result['status'] = $status;
		$result['message'] = $message;

		$result = json_encode($result);
		return $result;
	}

	function getServiceupdateotherplayertower(Request $request)
	{
		$param = $request->all();
		$userid = isset($param['userid']) ? $param['userid'] : '';
		$coin = isset($param['coin']) ? $param['coin'] : 0;
		$attack = isset($param['attack']) ? $param['attack'] : 0;
		$otherUserid = isset($param['otheruserid']) ? $param['otheruserid'] : '';
		$otherTowerinfo = $request->getContent();
		$userWin = isset($param['useridwin']) ? $param['useridwin'] : '';

		$status = 1;

		$otherTowerinfo = urldecode($otherTowerinfo);
		$otherTowerinfo = json_decode($otherTowerinfo, true);
		$other_player_tower_info = isset($otherTowerinfo['playerbuilding']) ? $otherTowerinfo['playerbuilding'] : 0;
		$otherAttack = isset($otherTowerinfo['attack']) ? $otherTowerinfo['attack'] : 0;
		$otherCoin = isset($otherTowerinfo['currentcoin']) ? $otherTowerinfo['currentcoin'] : 0;
		$otherCoinLost = isset($otherTowerinfo['coinlost']) ? $otherTowerinfo['coinlost'] : 0;
		$level_maintower_lost = 0;
		$level_warriortower_lost = 0;
		$level_herotower_lost = 0;
		$level_defendtower1_lost = 0;
		$level_defendtower2_lost = 0;

		foreach ($other_player_tower_info as $item) {
			if ($item['id'] == 0) {
				if (isset($item['levellost'])) {
					$level_maintower_lost = $item['levellost'];
				}
			}
			if ($item['id'] == 1) {
				if (isset($item['levellost'])) {
					$level_warriortower_lost = $item['levellost'];
				}
			}
			if ($item['id'] == 2) {
				if (isset($item['levellost'])) {
					$level_herotower_lost = $item['levellost'];
				}
			}
			if ($item['id'] == 3) {
				if (isset($item['levellost'])) {
					$level_defendtower1_lost = $item['levellost'];
				}
			}
			if ($item['id'] == 4) {
				if (isset($item['levellost'])) {
					$level_defendtower2_lost = $item['levellost'];
				}
			}
		}

		$player = new player_2();
		$playerwin = $player->getPlayer($userWin);
		if ($playerwin) {
			$userid_win = $playerwin->id;
		} else {
			$userid_win = 0;
		}
		$userid_idplayer = $player->updateUserWinLose($userid, $coin, $attack, $userWin);
		$otherUserid_idplayer = $player->updateUserWinLose($otherUserid, $otherCoin, $otherAttack, $userWin);

		$towerinfo = new towerinfo_2();
		$towerinfo->updateTowerinfo($otherUserid_idplayer, $other_player_tower_info);

		$matchlog = new matchlog_2();
		$matchlog->insertMatchlog($userid_idplayer, $otherUserid_idplayer, $userid_win, $otherCoinLost, $level_maintower_lost, $level_warriortower_lost, $level_herotower_lost, $level_defendtower1_lost, $level_defendtower2_lost);

		$noti_obj = new Notification();
		$userdanh = $player->getPlayer($userid);
		$userbidanh = $player->getPlayer($otherUserid);
		$userdanh_name = "";
		$userbidanh_gcm = "";
		$userbidanh_platform = "";
		if ($userdanh) {
			$userdanh_name = $userdanh->name;
		}
		if ($userbidanh) {
			$userbidanh_gcm = $userbidanh->gcmid;
			$userbidanh_platform = $userbidanh->platform;
		}

		if (!empty($userbidanh_gcm)) {
			$title = "Hey! Commander!";
			$body = "⚔ You have attacked by " . $userdanh_name . "! Open game to view!";
			$noti_obj->sendNoti($userbidanh_platform, $userbidanh_gcm, $title, $body);
		}

		$result['status'] = $status;

		$result = json_encode($result);
		return $result;
	}

	function getSavelogs(Request $request)
	{
		$param = $request->all();
		$content_get = $request->getContent();
		$content_get = urldecode($content_get);
		$content_get = json_decode($content_get, true);

		$loggunclash = new loggunclash_2();
		$loggunclash->insertLogApi($param, $content_get);

		$status = 1;
		$result['status'] = $status;
		$result = json_encode($result);
		return $result;
	}

	function getServicegcmid(Request $request)
	{
		$param = $request->all();
		$userid = isset($param['userid']) ? $param['userid'] : '';
		$gcmid = isset($param['gcm']) ? $param['gcm'] : '';

		$status = 1;
		$message = '';

		$player = new player_2();
		$updategcmid = $player->updateGcmid($userid, $gcmid);

		if (!$updategcmid) {
			$status = 0;
			$message = 'Userid not found';
		}

		$result['status'] = $status;
		$result['message'] = $message;

		$result = json_encode($result);
		return $result;
	}

	function checkEmptynumber($number)
	{
		return empty($number) ? 0 : $number;
	}

	function updateConfig()
	{
		$config = new config();
		$config->updateConfigDate();
		$config_content_db = $config->getConfig();
		$content['per_attack_diff'] = empty($config_content_db->per_attack_diff) ? 15 : $config_content_db->per_attack_diff;
		$content['time_off_from'] = empty($config_content_db->time_off_from) ? 15 : $config_content_db->time_off_from;
		$content['time_off_to'] = empty($config_content_db->time_off_to) ? 14400 : $config_content_db->time_off_to;
		$content['sum_win'] = empty($config_content_db->sum_win) ? 10 : $config_content_db->sum_win;
		$content['sum_lose'] = empty($config_content_db->sum_lose) ? 10 : $config_content_db->sum_lose;
		$content['updatedate'] = date("Y-m-d H:i:s");
		$content = json_encode($content);
		$file = fopen('config_file/config.json', "w");
		fwrite($file, $content);
		fclose($file);

		return 1;
	}

	function test()
	{
		//$test = "%7b%22playerbuilding%22%3a%5b%7b%22id%22%3a0%2c%22level%22%3a5%7d%2c%7b%22id%22%3a2%2c%22level%22%3a5%7d%2c%7b%22id%22%3a1%2c%22level%22%3a5%7d%2c%7b%22id%22%3a3%2c%22level%22%3a5%7d%2c%7b%22id%22%3a4%2c%22level%22%3a5%7d%5d%2c%22currentcoin%22%3a1600%2c%22attack%22%3a420300%7d";
		//$test = '{"playerbuilding":[{"id":0,"level":5},{"id":2,"level":5},{"id":1,"level":5},{"id":3,"level":5},{"id":4,"level":5}],"currentcoin":1600,"attack":420300}';
		//$test = str_replace(['%7b','%22','%3a','%5b','%2c','%7d','%5d'], ['{','"',':','[',',','}',']'], $test);
		//$test = urldecode($test);
		//$test = json_decode($test, true);

		$test = new player_2();
		$test->testConfig();

		echo "<pre>";
		print_r($test);
		echo "</pre>";

	}

}
