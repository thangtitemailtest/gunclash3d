<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class player extends Model
{
	protected $table = "player";
	public $timestamps = false;

	public function getUseridLogin($player, $check = 'obj')
	{
		if ($player) {
			if ($check == 'obj') {
				$userid = $player->deviceid;
				$type = 0;
				if (!empty($player->fbid)) {
					$userid = $player->fbid;
					$type = 3;
				} elseif (!empty($player->gamecenterid)) {
					$userid = $player->gamecenterid;
					$type = 2;
				} elseif (!empty($player->googleid)) {
					$userid = $player->googleid;
					$type = 1;
				}
			} else {
				$userid = $player['deviceid'];
				$type = 0;
				if (!empty($player['fbid'])) {
					$userid = $player['fbid'];
					$type = 3;
				} elseif (!empty($player['gamecenterid'])) {
					$userid = $player['gamecenterid'];
					$type = 2;
				} elseif (!empty($player['googleid'])) {
					$userid = $player['googleid'];
					$type = 1;
				}
			}
		} else {
			$userid = "";
			$type = 0;
		}

		$result['userid'] = $userid;
		$result['type'] = $type;

		return $result;
	}

	public function getPlayer($userid)
	{
		$player = $this::where('deviceid', '=', $userid)->first();

		return $player;
	}

	public function getPlayerId($id)
	{
		$player = $this::find($id);

		return $player;
	}

	public function insertUser($input)
	{
		$deviceid = isset($input['deviceid']) ? $input['deviceid'] : '';
		$checkplay = $this->getPlayer($deviceid);
		$result = [];

		if ($checkplay) {
			if (isset($input['country'])) {
				$checkplay->country = $input['country'];
			}
			if (isset($input['gcmid'])) {
				$checkplay->gcmid = $input['gcmid'];
			}
			if (isset($input['username'])) {
				$checkplay->name = $input['username'];
			}
			if (isset($input['fbid'])) {
				$checkplay->fbid = $input['fbid'];
			}
			if (isset($input['googleid'])) {
				$checkplay->googleid = $input['googleid'];
			}
			if (isset($input['gamecenterid'])) {
				$checkplay->gamecenterid = $input['gamecenterid'];
			}
			$checkplay->updatedate = date('Y-m-d H:i:s');
			$checkplay->save();
			$result['userid'] = $checkplay->id;
			$result['coin'] = $checkplay->coin;
			$result['attack'] = $checkplay->attack;
		} else {
			$player = new player();
			$player->name = isset($input['username']) ? $input['username'] : '';
			$player->attack = isset($input['attack']) ? $input['attack'] : 0;
			$player->deviceid = isset($input['deviceid']) ? $input['deviceid'] : '';
			$player->fbid = isset($input['fbid']) ? $input['fbid'] : '';
			$player->googleid = isset($input['googleid']) ? $input['googleid'] : '';
			$player->gamecenterid = isset($input['gamecenterid']) ? $input['gamecenterid'] : '';
			$player->platform = isset($input['platform']) ? $input['platform'] : '';
			$player->country = isset($input['country']) ? $input['country'] : '';
			$player->gcmid = isset($input['gcmid']) ? $input['gcmid'] : '';
			$player->save();
			$result['userid'] = $player->id;
			$result['coin'] = 0;
			$result['attack'] = 0;
		}

		return $result;
	}

	public function updateDate($userid, $country)
	{
		$player = $this->getPlayer($userid);
		if ($player) {
			$player->updatedate = date('Y-m-d H:i:s');
			$player->country = $country;
			$player->save();
		}

		return 1;
	}

	public function updateGcmid($userid, $gcmid)
	{
		$player = $this->getPlayer($userid);
		if ($player) {
			$player->updatedate = date('Y-m-d H:i:s');
			$player->gcmid = $gcmid;
			$player->save();

			return 1;
		} else {
			return 0;
		}
	}

	public function updateUserinfo($userid, $coin, $attack = null)
	{
		$userInfo = $this->getPlayer($userid);
		if ($userInfo) {
			$userInfo->coin = $coin;
			$userInfo->attack = $attack;
			$userInfo->save();

			return $userInfo->id;
		} else {
			return 0;
		}
	}

	public function getOtherPlayerRandom($id, $attack)
	{
		$path_config = asset('/config_file/config.json');
		$config_content = json_decode(file_get_contents($path_config), true);
		$per_attack_diff = empty($config_content['per_attack_diff']) ? 15 : $config_content['per_attack_diff'];
		$time_off_from = empty($config_content['time_off_from']) ? 15 : $config_content['time_off_from'];
		$time_off_to = empty($config_content['time_off_to']) ? 14400 : $config_content['time_off_to'];

		$attack_min = $attack - ($attack * $per_attack_diff / 100) - 1;
		$attack_min = $attack_min < 0 ? 0 : $attack_min;
		$attack_max = $attack + ($attack * $per_attack_diff / 100) + 1;

		// thêm điều kiện thời gian offline
		$datetime = date('Y-m-d H:i:s');
		$datetime_min = date("Y-m-d H:i:s", strtotime("-" . $time_off_to . " minutes", strtotime($datetime)));
		$datetime_max = date("Y-m-d H:i:s", strtotime("-" . $time_off_from . " minutes", strtotime($datetime)));
		$otherPlayer = $this::select('id', 'attack', 'deviceid', 'coin', 'name', 'fbid', 'googleid', 'gamecenterid')
			->where('attack', '>', $attack_min)->where('attack', '<', $attack_max)
			->where('updatedate', '>=', $datetime_min)->where('updatedate', '<=', $datetime_max)
			->where('id', '<>', $id)
			->get()->toArray();
		if ($otherPlayer) {
			return $otherPlayer;
		} else {
			$otherPlayer = $this::select('id', 'attack', 'deviceid', 'coin', 'name', 'fbid', 'googleid', 'gamecenterid')
				->where('attack', '>', $attack_min)->where('attack', '<', $attack_max)
				->where('id', '<>', $id)
				->get()->toArray();
			if ($otherPlayer) {
				return $otherPlayer;
			} else {
				$otherPlayer = $this::select('id', 'attack', 'deviceid', 'coin', 'name', 'fbid', 'googleid', 'gamecenterid')
					->where('id', '<>', $id)
					->where('attack', '>', 0)
					->get()->toArray();

				return $otherPlayer;
			}
		}
	}

	public function testConfig()
	{
		$path_config = asset('/config_file/config.json');
		$config_content = json_decode(file_get_contents($path_config), true);
		if (empty($config_content['updatedate'])) {
			$per_attack_diff = 15;
			$time_off_from = 15;
			$time_off_to = 14400;
		} else {
			$updatedate = $config_content['updatedate'];
			$updatedate_add = date("Y-m-d H:i:s", strtotime("+5 hours", strtotime($updatedate)));
			$date_cur = date("Y-m-d H:i:s");

			if ($date_cur >= $updatedate_add) {
				$config = new config();
				$config->updateConfigDate();
				$config_content_db = $config->getConfig();
				$content['per_attack_diff'] = empty($config_content_db->per_attack_diff) ? 15 : $config_content_db->per_attack_diff;
				$content['time_off_from'] = empty($config_content_db->time_off_from) ? 15 : $config_content_db->time_off_from;
				$content['time_off_to'] = empty($config_content_db->time_off_to) ? 14400 : $config_content_db->time_off_to;
				$content['updatedate'] = date("Y-m-d H:i:s");
				$content = json_encode($content);
				$file = fopen('config_file/config.json', "w");
				fwrite($file, $content);
				fclose($file);

				$per_attack_diff = empty($config_content_db->per_attack_diff) ? 15 : $config_content_db->per_attack_diff;
				$time_off_from = empty($config_content_db->time_off_from) ? 15 : $config_content_db->time_off_from;
				$time_off_to = empty($config_content_db->time_off_to) ? 14400 : $config_content_db->time_off_to;
			} else {
				$per_attack_diff = empty($config_content['per_attack_diff']) ? 15 : $config_content['per_attack_diff'];
				$time_off_from = empty($config_content['time_off_from']) ? 15 : $config_content['time_off_from'];
				$time_off_to = empty($config_content['time_off_to']) ? 14400 : $config_content['time_off_to'];
			}
		}

		$otherPlayer = $this::select('id1', 'attack', 'deviceid', 'coin')->where('id', '<>', $per_attack_diff)->get()->toArray();

		return $otherPlayer;
	}

}
