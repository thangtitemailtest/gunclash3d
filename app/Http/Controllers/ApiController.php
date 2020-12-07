<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\player;
use App\Model\towerinfo;
use App\Model\matchlog;
use App\Model\loggunclash;
use App\Model\config;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
	function getServicelogin(Request $request)
	{
		$param = $request->all();

		$player = new player();
		$player_info = $player->insertUser($param);

		$coin = $player_info['coin'];
		$attack = $player_info['attack'];
		$coinlost = 0;
		$userid = $player_info['userid'];

		$playertower = new towerinfo();
		$check_play_tower_info = $playertower->getTowerinfo($userid);
		if (!$check_play_tower_info) {
			$playertower->insertTowerinfo($userid);
			$player_tower_info = $playertower->getTowerinfoArray0();
		} else {
			$player_tower_info = $playertower->getTowerinfoArray($userid);
			$matchlog = new matchlog();
			$matchlog_info = $matchlog->getMatchlog($userid);
			$player_tower_info[0]['levellost'] = isset($matchlog_info->level_maintower_lost) ? $matchlog_info->level_maintower_lost : 0;
			$player_tower_info[1]['levellost'] = isset($matchlog_info->level_warriortower_lost) ? $matchlog_info->level_warriortower_lost : 0;
			$player_tower_info[2]['levellost'] = isset($matchlog_info->level_herotower_lost) ? $matchlog_info->level_herotower_lost : 0;
			$player_tower_info[3]['levellost'] = isset($matchlog_info->level_defendtower1_lost) ? $matchlog_info->level_defendtower1_lost : 0;
			$player_tower_info[4]['levellost'] = isset($matchlog_info->level_defendtower2_lost) ? $matchlog_info->level_defendtower2_lost : 0;
			$coinlost = isset($matchlog_info->coin_lost) ? $matchlog_info->coin_lost : 0;

			if (isset($matchlog_info->id)) {
				$idmatchlog = $matchlog_info->id;
				$matchlog->updateMatchlog($idmatchlog);
			}

			if (isset($matchlog_info->useridattack)) {
				$userid_attack = $matchlog_info->useridattack;
				$player_attack = $player->getPlayerId($userid_attack);
				if ($player_attack) {
					$attack_userid = $player_attack->deviceid;
					$attack_username = $player_attack->name;
				}
			}
		}

		// insert log login
		/*$loggunclash = new loggunclash();
		$deviceid = isset($param['deviceid']) ? $param['deviceid'] : "";
		$country = isset($param['country']) ? $param['country'] : '';
		$loggunclash->insertLogLogin($deviceid, $country);*/

		$result['playerbuilding'] = $player_tower_info;
		$result['attack_userid'] = empty($attack_userid) ? "" : $attack_userid;
		$result['attack_username'] = empty($attack_username) ? "" : $attack_username;
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

		$player = new player();
		$userInfo_id = $player->updateUserinfo($userid, $coin, $attack);

		if ($userInfo_id) {
			$towerinfo = new towerinfo();
			$towerinfo->updateTowerinfo($userInfo_id, $player_tower_info_building);
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

		$player = new player();
		$player_info = $player->getPlayer($userid);
		if ($player_info) {
			$coin = $player_info->coin;
			$attack = $player_info->attack;
			$userid_idplayer = $player_info->id;

			$playertower = new towerinfo();
			$player_tower_info = $playertower->getTowerinfoArray($userid_idplayer);
			$matchlog = new matchlog();
			$matchlog_info = $matchlog->getMatchlog($userid_idplayer);
			$player_tower_info[0]['levellost'] = isset($matchlog_info->level_maintower_lost) ? $matchlog_info->level_maintower_lost : 0;
			$player_tower_info[1]['levellost'] = isset($matchlog_info->level_warriortower_lost) ? $matchlog_info->level_warriortower_lost : 0;
			$player_tower_info[2]['levellost'] = isset($matchlog_info->level_herotower_lost) ? $matchlog_info->level_herotower_lost : 0;
			$player_tower_info[3]['levellost'] = isset($matchlog_info->level_defendtower1_lost) ? $matchlog_info->level_defendtower1_lost : 0;
			$player_tower_info[4]['levellost'] = isset($matchlog_info->level_defendtower2_lost) ? $matchlog_info->level_defendtower2_lost : 0;
			$coinlost = isset($matchlog_info->coin_lost) ? $matchlog_info->coin_lost : 0;

			$result['playerbuilding'] = $player_tower_info;
			$result['currentcoin'] = $this->checkEmptynumber($coin);
			$result['coinlost'] = $this->checkEmptynumber($coinlost);
			$result['attack'] = $this->checkEmptynumber($attack);

			if (isset($matchlog_info->id)) {
				$idmatchlog = $matchlog_info->id;
				$matchlog->updateMatchlog($idmatchlog);
			}

			if (isset($matchlog_info->useridattack)) {
				$userid_attack = $matchlog_info->useridattack;
				$player_attack = $player->getPlayerId($userid_attack);
				if ($player_attack) {
					$attack_userid = $player_attack->deviceid;
					$attack_username = $player_attack->name;
				}
			}

			$result['attack_userid'] = empty($attack_userid) ? "" : $attack_userid;
			$result['attack_username'] = empty($attack_username) ? "" : $attack_username;
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
		$player = new player();
		$player_info = $player->getPlayer($userid);
		if ($player_info) {
			$attack = empty($player_info->attack) ? 0 : $player_info->attack;
			$userid_idplayer = $player_info->id;
			$sum_win = empty($player_info->sum_win) ? 0 : $player_info->sum_win;
			$sum_lose = empty($player_info->sum_lose) ? 0 : $player_info->sum_lose;

			$towerinfo = new towerinfo();
			$result['playerbuilding'] = [];
			$otherPlayer = $player->getOtherPlayerRandom($userid_idplayer, $attack, $sum_win, $sum_lose);
			if ($otherPlayer) {
				// random
				$otherPlayer = $otherPlayer[array_rand($otherPlayer)];
				// end cmt random
				$userid_other = $otherPlayer['id'];
				$userid_other_deviceid = $otherPlayer['deviceid'];
				$userid_other_username = $otherPlayer['name'];
				$attack_other = $otherPlayer['attack'];
				$coin_other = $otherPlayer['coin'];
				$otherTowerinfo = $towerinfo->getTowerinfoArray($userid_other);

				$result['playerbuilding'] = $otherTowerinfo;
				$result['attack'] = $attack_other;
				$result['currentcoin'] = $coin_other;
				$result['otherusername'] = $userid_other_username;
				$result['otheruserdeviceid'] = $userid_other_deviceid;

				$useridLogin = $player->getUseridLogin($otherPlayer, 'arr');
				$result['otheruserid'] = $useridLogin['userid'];
				$result['type'] = $useridLogin['type'];
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

		$player = new player();
		$playerwin = $player->getPlayer($userWin);
		if ($playerwin) {
			$userid_win = $playerwin->id;
		} else {
			$userid_win = 0;
		}
		$userid_idplayer = $player->updateUserWinLose($userid, $coin, $attack, $userWin);
		$otherUserid_idplayer = $player->updateUserWinLose($otherUserid, $otherCoin, $otherAttack, $userWin);

		$towerinfo = new towerinfo();
		$towerinfo->updateTowerinfo($otherUserid_idplayer, $other_player_tower_info);

		$matchlog = new matchlog();
		$matchlog->insertMatchlog($userid_idplayer, $otherUserid_idplayer, $userid_win, $otherCoinLost, $level_maintower_lost, $level_warriortower_lost, $level_herotower_lost, $level_defendtower1_lost, $level_defendtower2_lost);

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

		$loggunclash = new loggunclash();
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
		$gcmid = isset($param['gcmid']) ? $param['gcmid'] : '';

		$status = 1;
		$message = '';

		$player = new player();
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

		$test = new player();
		$test->testConfig();

		echo "<pre>";
		print_r($test);
		echo "</pre>";

	}

}
