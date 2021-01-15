<?php

namespace App\Model;

use App\Http\Controllers\ApiController_2;
use Illuminate\Database\Eloquent\Model;

class player_2 extends Model
{
	protected $table = "player_2";
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

	public function randomNamePlayer($id)
	{
		$player = $this->getPlayerId($id);
		$username = '';
		if ($player) {
			$apicontroller = new ApiController_2();
			$danhsachten = $apicontroller->DanhSachTen();
			$username = $danhsachten[array_rand($danhsachten)];
			$player->name = $username;
			$player->save();
		}

		return $username;
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
			if (isset($input['gcm'])) {
				$checkplay->gcmid = $input['gcm'];
			}
			$username = isset($input['username']) ? $input['username'] : '';
			if (empty($username)) {
				if (empty($checkplay->name)) {
					$apicontroller = new ApiController_2();
					$danhsachten = $apicontroller->DanhSachTen();
					$username = $danhsachten[array_rand($danhsachten)];
					$checkplay->name = $username;
				}
			} else {
				$checkplay->name = $username;
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
			$player = new player_2();
			$username = isset($input['username']) ? $input['username'] : '';
			if (empty($username)) {
				$apicontroller = new ApiController_2();
				$danhsachten = $apicontroller->DanhSachTen();
				$username = $danhsachten[array_rand($danhsachten)];
			}
			$player->name = $username;
			$player->attack = isset($input['attack']) ? $input['attack'] : 0;
			$player->deviceid = isset($input['deviceid']) ? $input['deviceid'] : '';
			$player->fbid = isset($input['fbid']) ? $input['fbid'] : '';
			$player->googleid = isset($input['googleid']) ? $input['googleid'] : '';
			$player->gamecenterid = isset($input['gamecenterid']) ? $input['gamecenterid'] : '';
			$player->platform = isset($input['platform']) ? $input['platform'] : '';
			$player->country = isset($input['country']) ? $input['country'] : '';
			$player->gcmid = isset($input['gcm']) ? $input['gcm'] : '';
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

	public function updateUserinfo($userid, $coin, $attack = null, $username = '')
	{
		$userInfo = $this->getPlayer($userid);
		if ($userInfo) {
			$userInfo->coin = $coin;
			$userInfo->attack = $attack;
			if (empty($username)) {
				if (empty($userInfo->name)) {
					$apicontroller = new ApiController_2();
					$danhsachten = $apicontroller->DanhSachTen();
					$username = $danhsachten[array_rand($danhsachten)];
					$userInfo->name = $username;
				}
			} else {
				$userInfo->name = $username;
			}
			$userInfo->save();

			return $userInfo->id;
		} else {
			return 0;
		}
	}

	public function updateUserWinLose($userid, $coin, $attack, $userWin)
	{
		$userInfo = $this->getPlayer($userid);
		if ($userInfo) {
			$sum_win = $userInfo->sum_win;
			$sum_lose = $userInfo->sum_lose;
			if ($userid == $userWin) {
				$sum_win++;
				$userInfo->sum_win = $sum_win;
			} else {
				$sum_lose++;
				$userInfo->sum_lose = $sum_lose;
			}
			$userInfo->coin = $coin;
			$userInfo->attack = $attack;
			$userInfo->save();

			return $userInfo->id;
		} else {
			return 0;
		}
	}

	public function getOtherPlayerRandom($id, $attack, $sum_win, $sum_lose)
	{
		$path_config = asset('/config_file/config.json');
		$config_content = json_decode(file_get_contents($path_config), true);
		$per_attack_diff = empty($config_content['per_attack_diff']) ? 10 : $config_content['per_attack_diff'];
		$time_off_from = empty($config_content['time_off_from']) ? 5 : $config_content['time_off_from'];
		$time_off_to = empty($config_content['time_off_to']) ? 4320 : $config_content['time_off_to'];
		$sum_win_conf = empty($config_content['sum_win']) ? 5 : $config_content['sum_win'];
		$sum_lose_conf = empty($config_content['sum_lose']) ? 5 : $config_content['sum_lose'];

		$attack_min = $attack - ($attack * $per_attack_diff / 100) - 1;
		$attack_min = $attack_min < 0 ? 1 : $attack_min;
		$attack_max = $attack + ($attack * $per_attack_diff / 100) + 1;

		$per_attack_diff_2 = $per_attack_diff + 10;
		$attack_min2 = $attack - ($attack * $per_attack_diff_2 / 100) - 1;
		$attack_min2 = $attack_min2 < 0 ? 1 : $attack_min2;
		$attack_max2 = $attack + ($attack * $per_attack_diff_2 / 100) + 1;

		$per_attack_diff_3 = $per_attack_diff + 50;
		$attack_min3 = $attack - ($attack * $per_attack_diff_3 / 100) - 1;
		$attack_min3 = $attack_min3 < 0 ? 1 : $attack_min3;
		$attack_max3 = $attack + ($attack * $per_attack_diff_3 / 100) + 1;

		// thêm điều kiện thời gian offline
		$datetime = date('Y-m-d H:i:s');
		$datetime_min = date("Y-m-d H:i:s", strtotime("-" . $time_off_to . " minutes", strtotime($datetime)));
		$datetime_max = date("Y-m-d H:i:s", strtotime("-" . $time_off_from . " minutes", strtotime($datetime)));

		$time_off_to_2 = $time_off_to + 2880;
		$datetime_min_2 = date("Y-m-d H:i:s", strtotime("-" . $time_off_to_2 . " minutes", strtotime($datetime)));

		$datetoday = date('Y-m-d');
		$dateattack_from = $datetoday . " 00:00:00";
		$dateattack_to = $datetoday . " 23:59:59";
		$datetoday_2 = date('Y-m-d', strtotime($datetoday . " -2 day"));
		$dateattack_to_2 = $datetoday_2 . " 23:59:59";

		if ($sum_lose >= $sum_lose_conf) {
			$player_info = $this->getPlayerId($id);
			$player_info->sum_lose = 0;
			$player_info->save();

			$arrid[$id] = $id;
			$otherPlayer = $this->queryRandom($arrid, $attack_min2, $attack, $datetime_min_2, $datetime_max, $dateattack_from, $dateattack_to_2)->get()->toArray();
			if (count($otherPlayer) < 9) {
				if ($otherPlayer) {
					foreach ($otherPlayer as $item) {
						$arrid[$item['id']] = $item['id'];
					}
				}
				$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, $attack_min2, $attack, $datetime_min_2, $datetime_max)->get()->toArray();
				$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
			}

			if (count($otherPlayer) < 9) {
				if ($otherPlayer) {
					foreach ($otherPlayer as $item) {
						$arrid[$item['id']] = $item['id'];
					}
				}
				$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, $attack_min3, $attack, $datetime_min_2, $datetime_max)->get()->toArray();
				$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
			}

			if (count($otherPlayer) < 9) {
				if ($otherPlayer) {
					foreach ($otherPlayer as $item) {
						$arrid[$item['id']] = $item['id'];
					}
				}
				$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, $attack_min3, $attack, '', '')->limit(50)->get()->toArray();
				$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
			}

			if (count($otherPlayer) < 9) {
				if ($otherPlayer) {
					foreach ($otherPlayer as $item) {
						$arrid[$item['id']] = $item['id'];
					}
				}
				$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, 1, $attack, '', '')->limit(50)->get()->toArray();
				$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
			}

			return $otherPlayer;
		}

		if ($sum_win >= $sum_win_conf) {
			$player_info = $this->getPlayerId($id);
			$player_info->sum_win = 0;
			$player_info->save();

			$arrid[$id] = $id;
			$otherPlayer = $this->queryRandom($arrid, $attack, $attack_max, $datetime_min_2, $datetime_max, $dateattack_from, $dateattack_to_2)->get()->toArray();
			if (count($otherPlayer) < 9) {
				if ($otherPlayer) {
					foreach ($otherPlayer as $item) {
						$arrid[$item['id']] = $item['id'];
					}
				}
				$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, $attack, $attack_max2, $datetime_min_2, $datetime_max)->get()->toArray();
				$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
			}

			if (count($otherPlayer) < 9) {
				if ($otherPlayer) {
					foreach ($otherPlayer as $item) {
						$arrid[$item['id']] = $item['id'];
					}
				}
				$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, $attack, $attack_max3, $datetime_min_2, $datetime_max)->get()->toArray();
				$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
			}

			if (count($otherPlayer) < 9) {
				if ($otherPlayer) {
					foreach ($otherPlayer as $item) {
						$arrid[$item['id']] = $item['id'];
					}
				}
				$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, $attack_min3, $attack_max3, '', '')->limit(50)->get()->toArray();
				$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
			}

			if (count($otherPlayer) < 9) {
				if ($otherPlayer) {
					foreach ($otherPlayer as $item) {
						$arrid[$item['id']] = $item['id'];
					}
				}
				$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, $attack_min3, '', '', '')->limit(50)->get()->toArray();
				$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
			}

			if (count($otherPlayer) < 9) {
				if ($otherPlayer) {
					foreach ($otherPlayer as $item) {
						$arrid[$item['id']] = $item['id'];
					}
				}
				$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, 1, $attack_max3, '', '')->limit(50)->get()->toArray();
				$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
			}

			return $otherPlayer;
		}

		$arrid[$id] = $id;
		// lớn
		$otherPlayer = $this->queryRandom($arrid, $attack, $attack_max, $datetime_min, $datetime_max, $dateattack_from, $dateattack_to)->get()->toArray();
		if (count($otherPlayer) < 15) {
			if ($otherPlayer) {
				foreach ($otherPlayer as $item) {
					$arrid[$item['id']] = $item['id'];
				}
			}
			$otherPlayer_2 = $this->queryRandom($arrid, $attack, $attack_max2, $datetime_min_2, $datetime_max, $dateattack_from, $dateattack_to)->get()->toArray();
			$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
		}

		if (count($otherPlayer) < 15) {
			if ($otherPlayer) {
				foreach ($otherPlayer as $item) {
					$arrid[$item['id']] = $item['id'];
				}
			}
			$otherPlayer_2 = $this->queryRandom($arrid, $attack, $attack_max2, $datetime_min_2, $datetime_max, $dateattack_to, $dateattack_to_2)->get()->toArray();
			$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
		}

		if (count($otherPlayer) < 15) {
			if ($otherPlayer) {
				foreach ($otherPlayer as $item) {
					$arrid[$item['id']] = $item['id'];
				}
			}
			$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, $attack, $attack_max, $datetime_min, $datetime_max)->get()->toArray();
			$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
		}

		if (count($otherPlayer) < 15) {
			if ($otherPlayer) {
				foreach ($otherPlayer as $item) {
					$arrid[$item['id']] = $item['id'];
				}
			}
			$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, $attack, $attack_max2, $datetime_min_2, $datetime_max)->get()->toArray();
			$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
		}

		if (count($otherPlayer) < 15) {
			if ($otherPlayer) {
				foreach ($otherPlayer as $item) {
					$arrid[$item['id']] = $item['id'];
				}
			}
			$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, $attack, $attack_max3, $datetime_min_2, $datetime_max)->get()->toArray();
			$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
		}

		if (count($otherPlayer) > 15) {
			$numran = count($otherPlayer) - 15;
			$arr_ran = array_rand($otherPlayer, $numran);
			if (is_array($arr_ran)) {
				foreach ($arr_ran as $key) {
					unset($otherPlayer[$key]);
				}
			} else {
				unset($otherPlayer[$arr_ran]);
			}
		}

		// bé
		$otherPlayer_be = $this->queryRandom($arrid, $attack_min, $attack, $datetime_min, $datetime_max, $dateattack_from, $dateattack_to)->get()->toArray();
		if (count($otherPlayer_be) < 15) {
			if ($otherPlayer_be) {
				foreach ($otherPlayer_be as $item) {
					$arrid[$item['id']] = $item['id'];
				}
			}
			$otherPlayer_2 = $this->queryRandom($arrid, $attack_min2, $attack, $datetime_min_2, $datetime_max, $dateattack_from, $dateattack_to)->get()->toArray();
			$otherPlayer_be = array_merge($otherPlayer_be, $otherPlayer_2);
		}

		if (count($otherPlayer_be) < 15) {
			if ($otherPlayer_be) {
				foreach ($otherPlayer_be as $item) {
					$arrid[$item['id']] = $item['id'];
				}
			}
			$otherPlayer_2 = $this->queryRandom($arrid, $attack_min2, $attack, $datetime_min_2, $datetime_max, $dateattack_to, $dateattack_to_2)->get()->toArray();
			$otherPlayer_be = array_merge($otherPlayer_be, $otherPlayer_2);
		}

		if (count($otherPlayer_be) < 15) {
			if ($otherPlayer_be) {
				foreach ($otherPlayer_be as $item) {
					$arrid[$item['id']] = $item['id'];
				}
			}
			$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, $attack_min, $attack, $datetime_min, $datetime_max)->get()->toArray();
			$otherPlayer_be = array_merge($otherPlayer_be, $otherPlayer_2);
		}

		if (count($otherPlayer_be) < 15) {
			if ($otherPlayer_be) {
				foreach ($otherPlayer_be as $item) {
					$arrid[$item['id']] = $item['id'];
				}
			}
			$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, $attack_min2, $attack, $datetime_min_2, $datetime_max)->get()->toArray();
			$otherPlayer_be = array_merge($otherPlayer_be, $otherPlayer_2);
		}

		if (count($otherPlayer_be) < 15) {
			if ($otherPlayer_be) {
				foreach ($otherPlayer_be as $item) {
					$arrid[$item['id']] = $item['id'];
				}
			}
			$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, $attack_min3, $attack, $datetime_min_2, $datetime_max)->get()->toArray();
			$otherPlayer_be = array_merge($otherPlayer_be, $otherPlayer_2);
		}

		if (count($otherPlayer_be) > 15) {
			$numran = count($otherPlayer_be) - 15;
			$arr_ran = array_rand($otherPlayer_be, $numran);
			if (is_array($arr_ran)) {
				foreach ($arr_ran as $key) {
					unset($otherPlayer_be[$key]);
				}
			} else {
				unset($otherPlayer_be[$arr_ran]);
			}
		}

		$otherPlayer = array_merge($otherPlayer, $otherPlayer_be);

		if (count($otherPlayer) < 15) {
			if ($otherPlayer) {
				foreach ($otherPlayer as $item) {
					$arrid[$item['id']] = $item['id'];
				}
			}
			$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, 1, '', $datetime_min_2, $datetime_max)->limit(50)->get()->toArray();
			$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
		}

		if (count($otherPlayer) < 15) {
			if ($otherPlayer) {
				foreach ($otherPlayer as $item) {
					$arrid[$item['id']] = $item['id'];
				}
			}
			$otherPlayer_2 = $this->queryRandom_ko_matchlog($arrid, 1, '', '', '')->limit(50)->get()->toArray();
			$otherPlayer = array_merge($otherPlayer, $otherPlayer_2);
		}

		return $otherPlayer;
	}

	public function queryRandom($arrid, $attack_min, $attack_max, $datetime_min, $datetime_max, $dateattack_from, $dateattack_to)
	{
		$otherPlayer = $this::join('matchlog_2', 'player_2.id', '=', 'matchlog_2.useridattack')
			->select('player_2.id as id', 'player_2.attack as attack', 'player_2.deviceid as deviceid', 'player_2.coin as coin', 'player_2.name as name', 'player_2.fbid as fbid', 'player_2.googleid as googleid', 'player_2.gamecenterid as gamecenterid')
			->where('player_2.attack', '>=', $attack_min)
			->where('player_2.attack', '<', $attack_max)
			->where('player_2.updatedate', '>=', $datetime_min)
			->where('player_2.updatedate', '<=', $datetime_max)
			->where('matchlog_2.createdate', '>=', $dateattack_from)
			->where('matchlog_2.createdate', '<=', $dateattack_to)
			->whereNotIn('player_2.id', $arrid)
			->groupBy('player_2.id');

		return $otherPlayer;
	}

	public function queryRandom_ko_matchlog($arrid, $attack_min, $attack_max, $datetime_min, $datetime_max)
	{
		$otherPlayer = $this::select('id', 'attack', 'deviceid', 'coin', 'name', 'fbid', 'googleid', 'gamecenterid');
		if (!empty($attack_min)) {
			$otherPlayer->where('attack', '>=', $attack_min);
		}
		if (!empty($attack_max)) {
			$otherPlayer->where('attack', '<', $attack_max);
		}
		if (!empty($datetime_min)) {
			$otherPlayer->where('updatedate', '>=', $datetime_min);
		}
		if (!empty($datetime_max)) {
			$otherPlayer->where('updatedate', '<=', $datetime_max);
		}

		$otherPlayer->whereNotIn('id', $arrid)
			->groupBy('id');

		return $otherPlayer;
	}

	public function getAllPlayerEmptyName()
	{
		$player = $this::select('name', 'id')->where('name', '=', '')->get()->toArray();

		return $player;
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


	public function getOtherPlayerRandomBackup($id, $attack, $sum_win, $sum_lose)
	{
		$path_config = asset('/config_file/config.json');
		$config_content = json_decode(file_get_contents($path_config), true);
		$per_attack_diff = empty($config_content['per_attack_diff']) ? 10 : $config_content['per_attack_diff'];
		$time_off_from = empty($config_content['time_off_from']) ? 5 : $config_content['time_off_from'];
		$time_off_to = empty($config_content['time_off_to']) ? 4320 : $config_content['time_off_to'];
		$sum_win_conf = empty($config_content['sum_win']) ? 5 : $config_content['sum_win'];
		$sum_lose_conf = empty($config_content['sum_lose']) ? 5 : $config_content['sum_lose'];

		$attack_min = $attack - ($attack * $per_attack_diff / 100) - 1;
		$attack_min = $attack_min < 0 ? 0 : $attack_min;
		$attack_max = $attack + ($attack * $per_attack_diff / 100) + 1;

		$per_attack_diff_2 = $per_attack_diff + 10;
		$attack_min2 = $attack - ($attack * $per_attack_diff_2 / 100) - 1;
		$attack_min2 = $attack_min2 < 0 ? 0 : $attack_min2;
		$attack_max2 = $attack + ($attack * $per_attack_diff_2 / 100) + 1;

		// thêm điều kiện thời gian offline
		$datetime = date('Y-m-d H:i:s');
		$datetime_min = date("Y-m-d H:i:s", strtotime("-" . $time_off_to . " minutes", strtotime($datetime)));
		$datetime_max = date("Y-m-d H:i:s", strtotime("-" . $time_off_from . " minutes", strtotime($datetime)));

		$time_off_to_2 = $time_off_to + 2880;
		$datetime_min_2 = date("Y-m-d H:i:s", strtotime("-" . $time_off_to_2 . " minutes", strtotime($datetime)));

		if ($sum_win >= $sum_win_conf) {
			$player_info = $this->getPlayerId($id);
			$player_info->sum_win = 0;
			$player_info->save();

			$otherPlayer = $this::select('id', 'attack', 'deviceid', 'coin', 'name', 'fbid', 'googleid', 'gamecenterid')
				->where('attack', '>', $attack)->where('attack', '<', $attack_max)
				->where('updatedate', '>=', $datetime_min)->where('updatedate', '<=', $datetime_max)
				->get()->toArray();
			if ($otherPlayer) {
				return $otherPlayer;
			} else {
				$otherPlayer = $this::select('id', 'attack', 'deviceid', 'coin', 'name', 'fbid', 'googleid', 'gamecenterid')
					->where('attack', '>', $attack)->where('attack', '<', $attack_max)
					->get()->toArray();
				if ($otherPlayer) {
					return $otherPlayer;
				} else {
					$otherPlayer = $this::select('id', 'attack', 'deviceid', 'coin', 'name', 'fbid', 'googleid', 'gamecenterid')
						->where('attack', '>', $attack)
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
		}

		if ($sum_lose >= $sum_lose_conf) {
			$player_info = $this->getPlayerId($id);
			$player_info->sum_lose = 0;
			$player_info->save();

			$otherPlayer = $this::select('id', 'attack', 'deviceid', 'coin', 'name', 'fbid', 'googleid', 'gamecenterid')
				->where('attack', '>', $attack_min)->where('attack', '<', $attack)
				->where('updatedate', '>=', $datetime_min)->where('updatedate', '<=', $datetime_max)
				->get()->toArray();
			if ($otherPlayer) {
				return $otherPlayer;
			} else {
				$otherPlayer = $this::select('id', 'attack', 'deviceid', 'coin', 'name', 'fbid', 'googleid', 'gamecenterid')
					->where('attack', '>', $attack_min)->where('attack', '<', $attack)
					->get()->toArray();
				if ($otherPlayer) {
					return $otherPlayer;
				} else {
					$otherPlayer = $this::select('id', 'attack', 'deviceid', 'coin', 'name', 'fbid', 'googleid', 'gamecenterid')
						->where('attack', '>', 0)
						->where('attack', '<', $attack)
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
		}

		$otherPlayer = $this::select('id', 'attack', 'deviceid', 'coin', 'name', 'fbid', 'googleid', 'gamecenterid')
			->where('attack', '>', $attack_min)->where('attack', '<', $attack_max)
			->where('updatedate', '>=', $datetime_min)->where('updatedate', '<=', $datetime_max)
			->where('id', '<>', $id)
			->get()->toArray();
		if ($otherPlayer) {
			return $otherPlayer;
		} else {
			$otherPlayer = $this::select('id', 'attack', 'deviceid', 'coin', 'name', 'fbid', 'googleid', 'gamecenterid')
				->where('attack', '>', $attack_min2)->where('attack', '<', $attack_max2)
				->where('updatedate', '>=', $datetime_min)->where('updatedate', '<=', $datetime_max)
				->where('id', '<>', $id)
				->get()->toArray();
			if ($otherPlayer) {
				return $otherPlayer;
			} else {
				$otherPlayer = $this::select('id', 'attack', 'deviceid', 'coin', 'name', 'fbid', 'googleid', 'gamecenterid')
					->where('attack', '>', $attack_min)->where('attack', '<', $attack_max)
					->where('updatedate', '>=', $datetime_min_2)->where('updatedate', '<=', $datetime_max)
					->where('id', '<>', $id)
					->get()->toArray();
				if ($otherPlayer) {
					return $otherPlayer;
				} else {
					$otherPlayer = $this::select('id', 'attack', 'deviceid', 'coin', 'name', 'fbid', 'googleid', 'gamecenterid')
						->where('attack', '>', $attack_min2)->where('attack', '<', $attack_max2)
						->where('updatedate', '>=', $datetime_min_2)->where('updatedate', '<=', $datetime_max)
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
			}
		}
	}

}
