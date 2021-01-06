<?php

namespace App\Http\Controllers;

use App\Model\eventname;
use App\Model\loggunclash_2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReportControllerGun2 extends Controller
{

	function getUserconlaisaulevel(Request $request)
	{
		ini_set("memory_limit","-1");

		$params = $request->all();
		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);
			return view('report.gun2.userconlaisaulevel', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new loggunclash_2();
		$loggunclash = $log->SoUserConLaiSauCacLevel($input)->get();

		$deviceid = '';
		foreach ($loggunclash as $item) {
			if ($item->level > 0) {
				if ($deviceid != $item->deviceid) {
					$lv = $item->level;
					$deviceid = $item->deviceid;
					$datachart[$lv - 1]['soluong']++;
				}
			}
		}
		$datachart = json_encode($datachart);

		return view('report.gun2.userconlaisaulevel', compact('input', 'datachart'));
	}

	function getSotiencuausertheolevel(Request $request)
	{
		ini_set("memory_limit","-1");

		$params = $request->all();
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			return view('report.gun2.sotiencuausertheolevel', compact('input'));
		} else {
			$input = $params;
		}

		$log = new loggunclash_2();
		$loggunclash = $log->LocSoTienCuaUser($input)->get();

		$level_truoc = -1;
		$deviceid_truoc = '';

		foreach ($loggunclash as $key => $item) {
			if ($deviceid_truoc == $item->deviceid && $level_truoc == $item->level) {
				$loggunclash->forget($key);
			}

			$deviceid_truoc = $item->deviceid;
			$level_truoc = $item->level;
		}

		$logpagi = $loggunclash->paginate(100);

		return view('report.gun2.sotiencuausertheolevel', compact('input', 'logpagi'));
	}

	function getLocsonguoichoipass(Request $request)
	{
		ini_set("memory_limit","-1");

		$params = $request->all();
		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);

			return view('report.gun2.locsonguoichoipass', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new loggunclash_2();
		$loggunclash = $log->LocSoNguoiChoiPass($input)->get();

		$deviceid = '';
		$lv_truoc = 0;
		foreach ($loggunclash as $item) {
			if ($item->level > 0) {
				if ($lv_truoc === $item->level && $deviceid === $item->deviceid) {
					continue;
				}

				$lv = $item->level;
				$datachart[$lv - 1]['soluong']++;

				$deviceid = $item->deviceid;
				$lv_truoc = $item->level;
			}
		}

		$datachart = json_encode($datachart);

		return view('report.gun2.locsonguoichoipass', compact('input', 'datachart'));
	}

	function getLocsonguoichoistart(Request $request)
	{
		ini_set("memory_limit","-1");

		$params = $request->all();
		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);

			return view('report.gun2.locsonguoichoistart', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new loggunclash_2();
		$loggunclash = $log->LocSoNguoiChoiStart($input)->get();

		$deviceid = '';
		$lv_truoc = 0;
		foreach ($loggunclash as $item) {
			if ($item->level > 0) {
				if ($lv_truoc === $item->level && $deviceid === $item->deviceid) {
					continue;
				}

				$lv = $item->level;
				$datachart[$lv - 1]['soluong']++;

				$deviceid = $item->deviceid;
				$lv_truoc = $item->level;
			}
		}

		$datachart = json_encode($datachart);

		return view('report.gun2.locsonguoichoistart', compact('input', 'datachart'));
	}

	function getLocsonguoichoilose(Request $request)
	{
		ini_set("memory_limit","-1");

		$params = $request->all();
		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);

			return view('report.gun2.locsonguoichoilose', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new loggunclash_2();
		$loggunclash = $log->LocSoNguoiChoiLose($input)->get();

		$deviceid = '';
		$lv_truoc = 0;
		foreach ($loggunclash as $item) {
			if ($item->level > 0) {
				if ($lv_truoc === $item->level && $deviceid === $item->deviceid) {
					continue;
				}

				$lv = $item->level;
				$datachart[$lv - 1]['soluong']++;

				$deviceid = $item->deviceid;
				$lv_truoc = $item->level;
			}
		}

		$datachart = json_encode($datachart);

		return view('report.gun2.locsonguoichoilose', compact('input', 'datachart'));
	}

	function getLocsotiennguoichoipass(Request $request)
	{
		ini_set("memory_limit","-1");

		$params = $request->all();
		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);

			return view('report.gun2.locsotiennguoichoipass', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
			$datachart[$i - 1]['vang'] = 0;
		}

		$log = new loggunclash_2();
		$loggunclash = $log->LocSoTienNguoiChoiPass($input)->get();

		foreach ($loggunclash as $item) {
			if ($item->level > 0) {
				$lv = $item->level;
				$vang = $item->c_coin;
				$datachart[$lv - 1]['soluong']++;
				$datachart[$lv - 1]['vang'] += $vang;
			}
		}

		foreach ($datachart as $key => $item) {
			if (empty($item['soluong'])) {
				$vang_tb = 0;
			} else {
				$vang_tb = $item['vang'] / $item['soluong'];
			}

			$datachart[$key]['vangtb'] = round($vang_tb);
		}

		$datachart = json_encode($datachart);

		return view('report.gun2.locsotiennguoichoipass', compact('input', 'datachart'));
	}

	function getLocsotiennguoichoilose(Request $request)
	{
		ini_set("memory_limit","-1");

		$params = $request->all();
		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);

			return view('report.gun2.locsotiennguoichoilose', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
			$datachart[$i - 1]['vang'] = 0;
		}

		$log = new loggunclash_2();
		$loggunclash = $log->LocSoTienNguoiChoiLose($input)->get();

		foreach ($loggunclash as $item) {
			if ($item->level > 0) {
				$lv = $item->level;
				$vang = $item->c_coin;
				$datachart[$lv - 1]['soluong']++;
				$datachart[$lv - 1]['vang'] += $vang;
			}
		}

		foreach ($datachart as $key => $item) {
			if (empty($item['soluong'])) {
				$vang_tb = 0;
			} else {
				$vang_tb = $item['vang'] / $item['soluong'];
			}

			$datachart[$key]['vangtb'] = round($vang_tb);
		}

		$datachart = json_encode($datachart);

		return view('report.gun2.locsotiennguoichoilose', compact('input', 'datachart'));
	}

	function getQuocgiacosologinnhieunhat(Request $request)
	{
		ini_set("memory_limit","-1");

		$params = $request->all();
		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);

			return view('report.gun2.quocgiacosologinnhieunhat', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		$log = new loggunclash_2();
		$loggunclash = $log->QuocGiaCoSoLoginNhieuNhat($input)->get();

		$arr_country = [];
		foreach ($loggunclash as $item) {
			if (empty($arr_country[$item->country])) $arr_country[$item->country] = 0;
			$arr_country[$item->country]++;
		}

		arsort($arr_country);
		$dem = 0;
		foreach ($arr_country as $key => $item) {
			if ($dem < 5) {
				$datachart[$dem]['label'] = $key;
				$datachart[$dem]['value'] = $item;
			}
			$dem++;
		}

		$datachart = json_encode($datachart);

		return view('report.gun2.quocgiacosologinnhieunhat', compact('input', 'datachart'));
	}

	function getLevelusermuainapp(Request $request)
	{
		ini_set("memory_limit","-1");

		$params = $request->all();

		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);
			return view('report.gun2.levelusermuainapp', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new loggunclash_2();
		$loggunclash = $log->LocLevelUserMuaInapp($input)->get();

		foreach ($loggunclash as $item) {
			if ($item->level > 0) {
				$lv = $item->level;
				$datachart[$lv - 1]['soluong']++;
			}
		}

		$datachart = json_encode($datachart);

		return view('report.gun2.levelusermuainapp', compact('input', 'datachart'));
	}

	function getLogevent(Request $request)
	{
		ini_set("memory_limit","-1");

		$params = $request->all();

		$eventname = new eventname();
		$listEventname = $eventname->getListeventname();

		$log = new loggunclash_2();
		$listColumnLog = $log->getColumn();

		if (empty($params['time'])) {
			$input = [
				'eventname' => '',
				'week' => '',
				'time' => 'homnay',
			];
			return view('report.gun2.logevent', compact('input', 'listEventname', 'listColumnLog'));
		} else {
			$input = $params;
		}


		$loggunclash = $log->LogLogevent($input)->get();

		$logpagi = $loggunclash->paginate(50);

		return view('report.gun2.logevent', compact('input', 'logpagi', 'listEventname', 'listColumnLog'));
	}
}
