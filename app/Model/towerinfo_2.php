<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class towerinfo_2 extends Model
{
	protected $table = "towerinfo_2";
	public $timestamps = false;

	public function getTowerinfo($userid)
	{
		$towerinfo = $this::where('userid', '=', $userid)->first();

		return $towerinfo;
	}

	public function insertTowerinfo($userid)
	{
		$towerinfo = new towerinfo_2();
		$towerinfo->userid = $userid;
		/*$towerinfo->coinrequire_maintower = 5000;
		$towerinfo->coinrequire_warriortower = 5000;
		$towerinfo->coinrequire_herotower = 5000;
		$towerinfo->coinrequire_defendtower1 = 5000;
		$towerinfo->coinrequire_defendtower2 = 5000;*/
		$towerinfo->save();

		return 1;
	}

	public function getTowerinfoArray0()
	{
		$player_tower_info = [];
		$player_tower_info[] = [
			"id" => 0,
			"level" => 0,
			"levellost" => 0,
			/*"name" => "MainTower",
			"coinrequire" => 5000,
			"isDestroyed" => 0,*/
		];
		$player_tower_info[] = [
			"id" => 1,
			"level" => 0,
			"levellost" => 0,
			/*"name" => "WarriorTower",
			"coinrequire" => 5000,
			"isDestroyed" => 0,*/
		];
		$player_tower_info[] = [
			"id" => 2,
			"level" => 0,
			"levellost" => 0,
			/*"name" => "HeroTower",
			"coinrequire" => 5000,
			"isDestroyed" => 0,*/
		];
		$player_tower_info[] = [
			"id" => 3,
			"level" => 0,
			"levellost" => 0,
			/*"name" => "DefendTower",
			"coinrequire" => 5000,
			"isDestroyed" => 0,*/
		];
		$player_tower_info[] = [
			"id" => 4,
			"level" => 0,
			"levellost" => 0,
			/*"name" => "DefendTower",
			"coinrequire" => 5000,
			"isDestroyed" => 0,*/
		];

		return $player_tower_info;
	}

	public function getTowerinfoArray($userid)
	{
		$towerinfo = $this->getTowerinfo($userid);
		$player_tower_info = [];
		if ($towerinfo) {
			$player_tower_info[] = [
				"id" => 0,
				"level" => $this->checkEmptynumber($towerinfo->level_maintower),
				/*"name" => "MainTower",
				"coinrequire" => $this->checkEmptynumber($towerinfo->coinrequire_maintower),
				"isDestroyed" => $this->checkEmptynumber($towerinfo->isdestroyed_maintower),*/
			];
			$player_tower_info[] = [
				"id" => 1,
				"level" => $this->checkEmptynumber($towerinfo->level_warriortower),
				/*"name" => "WarriorTower",
				"coinrequire" => $this->checkEmptynumber($towerinfo->coinrequire_warriortower),
				"isDestroyed" => $this->checkEmptynumber($towerinfo->isdestroyed_warriortower),*/
			];
			$player_tower_info[] = [
				"id" => 2,
				"level" => $this->checkEmptynumber($towerinfo->level_herotower),
				/*"name" => "HeroTower",
				"coinrequire" => $this->checkEmptynumber($towerinfo->coinrequire_herotower),
				"isDestroyed" => $this->checkEmptynumber($towerinfo->isdestroyed_herotower),*/
			];
			$player_tower_info[] = [
				"id" => 3,
				"level" => $this->checkEmptynumber($towerinfo->level_defendtower1),
				/*"name" => "DefendTower",
				"coinrequire" => $this->checkEmptynumber($towerinfo->coinrequire_defendtower1),
				"isDestroyed" => $this->checkEmptynumber($towerinfo->isdestroyed_defendtower1),*/
			];
			$player_tower_info[] = [
				"id" => 4,
				"level" => $this->checkEmptynumber($towerinfo->level_defendtower2),
				/*"name" => "DefendTower",
				"coinrequire" => $this->checkEmptynumber($towerinfo->coinrequire_defendtower2),
				"isDestroyed" => $this->checkEmptynumber($towerinfo->isdestroyed_defendtower2),*/
			];
		}

		return $player_tower_info;
	}

	public function getTowerinfoArray2($userid)
	{
		$towerinfo = $this->getTowerinfo($userid);
		$world = 1;
		$defendwarrior = 0;
		$player_tower_info = [];
		if ($towerinfo) {
			$player_tower_info[] = [
				"id" => 0,
				"level" => $this->checkEmptynumber($towerinfo->level_maintower),
				/*"name" => "MainTower",
				"coinrequire" => $this->checkEmptynumber($towerinfo->coinrequire_maintower),
				"isDestroyed" => $this->checkEmptynumber($towerinfo->isdestroyed_maintower),*/
			];
			$player_tower_info[] = [
				"id" => 1,
				"level" => $this->checkEmptynumber($towerinfo->level_warriortower),
				/*"name" => "WarriorTower",
				"coinrequire" => $this->checkEmptynumber($towerinfo->coinrequire_warriortower),
				"isDestroyed" => $this->checkEmptynumber($towerinfo->isdestroyed_warriortower),*/
			];
			$player_tower_info[] = [
				"id" => 2,
				"level" => $this->checkEmptynumber($towerinfo->level_herotower),
				/*"name" => "HeroTower",
				"coinrequire" => $this->checkEmptynumber($towerinfo->coinrequire_herotower),
				"isDestroyed" => $this->checkEmptynumber($towerinfo->isdestroyed_herotower),*/
			];
			$player_tower_info[] = [
				"id" => 3,
				"level" => $this->checkEmptynumber($towerinfo->level_defendtower1),
				/*"name" => "DefendTower",
				"coinrequire" => $this->checkEmptynumber($towerinfo->coinrequire_defendtower1),
				"isDestroyed" => $this->checkEmptynumber($towerinfo->isdestroyed_defendtower1),*/
			];
			$player_tower_info[] = [
				"id" => 4,
				"level" => $this->checkEmptynumber($towerinfo->level_defendtower2),
				/*"name" => "DefendTower",
				"coinrequire" => $this->checkEmptynumber($towerinfo->coinrequire_defendtower2),
				"isDestroyed" => $this->checkEmptynumber($towerinfo->isdestroyed_defendtower2),*/
			];

			$world = empty($towerinfo->world) ? 1 : $towerinfo->world;
			$defendwarrior = empty($towerinfo->defendwarrior) ? 0 : $towerinfo->defendwarrior;
		}

		$result['player_tower_info'] = $player_tower_info;
		$result['world'] = $world;
		$result['defendwarrior'] = $defendwarrior;

		return $result;
	}

	public function updateTowerinfo($userid, $player_tower_info, $otherdefendwarriorlost)
	{
		$towerinfo = $this->getTowerinfo($userid);
		if ($towerinfo) {
			foreach ($player_tower_info as $key => $item) {
				if ($item['id'] == 0) {
					if (isset($item['levellost'])) {
						$levellost = empty($item['levellost']) ? 0 : $item['levellost'];
						$level = empty($towerinfo->level_maintower) ? 0 : $towerinfo->level_maintower;
						$level_tru = $level - $levellost;
						if ($level_tru < 0) $level_tru = 1;
						$towerinfo->level_maintower = $level_tru;
					}
				}
				if ($item['id'] == 1) {
					if (isset($item['levellost'])) {
						$levellost = empty($item['levellost']) ? 0 : $item['levellost'];
						$level = empty($towerinfo->level_warriortower) ? 0 : $towerinfo->level_warriortower;
						$level_tru = $level - $levellost;
						if ($level_tru < 0) $level_tru = 1;
						$towerinfo->level_warriortower = $level_tru;
					}
				}
				if ($item['id'] == 2) {
					if (isset($item['levellost'])) {
						$levellost = empty($item['levellost']) ? 0 : $item['levellost'];
						$level = empty($towerinfo->level_herotower) ? 0 : $towerinfo->level_herotower;
						$level_tru = $level - $levellost;
						if ($level_tru < 0) $level_tru = 1;
						$towerinfo->level_herotower = $level_tru;
					}
				}
				if ($item['id'] == 3) {
					if (isset($item['levellost'])) {
						$levellost = empty($item['levellost']) ? 0 : $item['levellost'];
						$level = empty($towerinfo->level_defendtower1) ? 0 : $towerinfo->level_defendtower1;
						$level_tru = $level - $levellost;
						if ($level_tru < 0) $level_tru = 1;
						$towerinfo->level_defendtower1 = $level_tru;
					}
				}
				if ($item['id'] == 4) {
					if (isset($item['levellost'])) {
						$levellost = empty($item['levellost']) ? 0 : $item['levellost'];
						$level = empty($towerinfo->level_defendtower2) ? 0 : $towerinfo->level_defendtower2;
						$level_tru = $level - $levellost;
						if ($level_tru < 0) $level_tru = 1;
						$towerinfo->level_defendtower2 = $level_tru;
					}
				}
			}
			$defendwarrior = $towerinfo->defendwarrior;
			$otherdefendwarriorlost = empty($otherdefendwarriorlost) ? 0 : $otherdefendwarriorlost;
			$defendwarrior_tru = $defendwarrior - $otherdefendwarriorlost;
			if ($defendwarrior_tru < 0) $defendwarrior_tru = 0;
			$towerinfo->defendwarrior = $defendwarrior_tru;
			$towerinfo->save();
		}

		return 1;
	}

	public function updateTowerinfo2($userid, $player_tower_info, $world = 1, $attackwarrior = 0, $defendwarrior = 0)
	{
		$towerinfo = $this->getTowerinfo($userid);
		if ($towerinfo) {
			$towerinfo->world = $world;
			$towerinfo->attackwarrior = $attackwarrior;
			$towerinfo->defendwarrior = $defendwarrior;
			foreach ($player_tower_info as $key => $item) {
				if ($item['id'] == 0) {
					if (isset($item['level'])) {
						$towerinfo->level_maintower = $item['level'];
					}
					if (isset($item['coinrequire'])) {
						$towerinfo->coinrequire_maintower = $item['coinrequire'];
					}
					if (isset($item['isDestroyed'])) {
						$towerinfo->isdestroyed_maintower = $item['isDestroyed'];
					}
				}
				if ($item['id'] == 1) {
					if (isset($item['level'])) {
						$towerinfo->level_warriortower = $item['level'];
					}
					if (isset($item['coinrequire'])) {
						$towerinfo->coinrequire_warriortower = $item['coinrequire'];
					}
					if (isset($item['isDestroyed'])) {
						$towerinfo->isdestroyed_warriortower = $item['isDestroyed'];
					}
				}
				if ($item['id'] == 2) {
					if (isset($item['level'])) {
						$towerinfo->level_herotower = $item['level'];
					}
					if (isset($item['coinrequire'])) {
						$towerinfo->coinrequire_herotower = $item['coinrequire'];
					}
					if (isset($item['isDestroyed'])) {
						$towerinfo->isdestroyed_herotower = $item['isDestroyed'];
					}
				}
				if ($item['id'] == 3) {
					if (isset($item['level'])) {
						$towerinfo->level_defendtower1 = $item['level'];
					}
					if (isset($item['coinrequire'])) {
						$towerinfo->coinrequire_defendtower1 = $item['coinrequire'];
					}
					if (isset($item['isDestroyed'])) {
						$towerinfo->isdestroyed_defendtower1 = $item['isDestroyed'];
					}
				}
				if ($item['id'] == 4) {
					if (isset($item['level'])) {
						$towerinfo->level_defendtower2 = $item['level'];
					}
					if (isset($item['coinrequire'])) {
						$towerinfo->coinrequire_defendtower2 = $item['coinrequire'];
					}
					if (isset($item['isDestroyed'])) {
						$towerinfo->isdestroyed_defendtower2 = $item['isDestroyed'];
					}
				}
			}
			$towerinfo->save();
		}

		return 1;
	}

	public function checkEmptynumber($number)
	{
		return empty($number) ? 0 : $number;
	}
}
