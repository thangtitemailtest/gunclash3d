<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class matchlog extends Model
{
	protected $table = "matchlog";
	public $timestamps = false;

	public function getMatchlog($useriddefend)
	{
		$matchlog = $this::where('useriddefend', '=', $useriddefend)->orderBy('id', 'DESC')->first();

		return $matchlog;
	}

	public function insertMatchlog($userid, $otherUserid, $userWin, $coin_lost = 0, $level_maintower_lost = 0, $level_warriortower_lost = 0, $level_herotower_lost = 0, $level_defendtower1_lost = 0, $level_defendtower2_lost = 0)
	{
		$matchlog = new matchlog();
		$matchlog->useridattack = $userid;
		$matchlog->useriddefend = $otherUserid;
		$matchlog->useridwin = $userWin;
		$matchlog->coin_lost = $coin_lost;
		$matchlog->level_maintower_lost = $level_maintower_lost;
		$matchlog->level_warriortower_lost = $level_warriortower_lost;
		$matchlog->level_herotower_lost = $level_herotower_lost;
		$matchlog->level_defendtower1_lost = $level_defendtower1_lost;
		$matchlog->level_defendtower2_lost = $level_defendtower2_lost;
		$matchlog->checkgetdata = 0;
		$matchlog->save();

		return 1;
	}

	public function updateMatchlog($idmatchlog, $coin_lost = 0, $level_maintower_lost = 0, $level_warriortower_lost = 0, $level_herotower_lost = 0, $level_defendtower1_lost = 0, $level_defendtower2_lost = 0)
	{
		$matchlog = $this::find($idmatchlog);
		$matchlog->coin_lost = $coin_lost;
		$matchlog->level_maintower_lost = $level_maintower_lost;
		$matchlog->level_warriortower_lost = $level_warriortower_lost;
		$matchlog->level_herotower_lost = $level_herotower_lost;
		$matchlog->level_defendtower1_lost = $level_defendtower1_lost;
		$matchlog->level_defendtower2_lost = $level_defendtower2_lost;
		$matchlog->save();

		return 1;
	}

	public function getListDataAttack($useriddefend)
	{
		$matchlog = $this::where('useriddefend', '=', $useriddefend)->where('checkgetdata', '=', 0)->get();

		return $matchlog;
	}

	public function updateDataAttack($useriddefend)
	{
		$this::where('useriddefend', '=', $useriddefend)->where('checkgetdata', '=', 0)
			->update(['checkgetdata' => 1, 'coin_lost' => 0, 'level_maintower_lost' => 0, 'level_warriortower_lost' => 0, 'level_herotower_lost' => 0, 'level_defendtower1_lost' => 0, 'level_defendtower2_lost' => 0]);

		return 1;
	}

	public function getListLichSuDanh($useriddefend)
	{
		$list = $this::where('useriddefend', '=', $useriddefend)->orderBy('id', 'DESC')->limit(10)->get();

		return $list;
	}
}
