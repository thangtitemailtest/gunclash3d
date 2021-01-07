<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class matchlog_2 extends Model
{
	protected $table = "matchlog_2";
	public $timestamps = false;

	public function getMatchlog($useriddefend)
	{
		$matchlog = $this::where('useriddefend', '=', $useriddefend)->orderBy('id', 'DESC')->first();

		return $matchlog;
	}

	public function insertMatchlog($userid, $otherUserid, $userWin, $coin_lost = 0, $level_maintower_lost = 0, $level_warriortower_lost = 0, $level_herotower_lost = 0, $level_defendtower1_lost = 0, $level_defendtower2_lost = 0)
	{
		$matchlog = new matchlog_2();
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

	public function getListLichSuBiDanh($useriddefend)
	{
		$list = $this::where('useriddefend', '=', $useriddefend)
			->where('useridattack','<>',0)
			->orderBy('id', 'DESC')->limit(30)->get();

		return $list;
	}

	public function getListLichSuDanh($useridattack)
	{
		$list = $this::where('useridattack', '=', $useridattack)
			->where('useriddefend','<>',0)
			->orderBy('id', 'DESC')->limit(30)->get();

		return $list;
	}
}
