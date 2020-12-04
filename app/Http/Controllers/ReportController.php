<?php

namespace App\Http\Controllers;

use App\Model\eventname;
use Illuminate\Http\Request;
use App\Model\loggunclash;
use Illuminate\Support\Facades\Cache;

class ReportController extends Controller
{

	function getUserconlaisaulevel(Request $request)
	{
		$params = $request->all();
		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);
			return view('report.userconlaisaulevel', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new loggunclash();
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

		return view('report.userconlaisaulevel', compact('input', 'datachart'));
	}

	function getSotiencuausertheolevel(Request $request)
	{
		$params = $request->all();
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			return view('report.sotiencuausertheolevel', compact('input'));
		} else {
			$input = $params;
		}

		$log = new loggunclash();
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

		return view('report.sotiencuausertheolevel', compact('input', 'logpagi'));
	}

	function getLocsonguoichoipass(Request $request)
	{
		$params = $request->all();
		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);

			return view('report.locsonguoichoipass', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new loggunclash();
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

		return view('report.locsonguoichoipass', compact('input', 'datachart'));
	}

	function getLocsonguoichoistart(Request $request)
	{
		$params = $request->all();
		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);

			return view('report.locsonguoichoistart', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new loggunclash();
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

		return view('report.locsonguoichoistart', compact('input', 'datachart'));
	}

	function getLocsonguoichoilose(Request $request)
	{
		$params = $request->all();
		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);

			return view('report.locsonguoichoilose', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new loggunclash();
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

		return view('report.locsonguoichoilose', compact('input', 'datachart'));
	}

	function getLocsotiennguoichoipass(Request $request)
	{
		$params = $request->all();
		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);

			return view('report.locsotiennguoichoipass', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
			$datachart[$i - 1]['vang'] = 0;
		}

		$log = new loggunclash();
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

		return view('report.locsotiennguoichoipass', compact('input', 'datachart'));
	}

	function getLocsotiennguoichoilose(Request $request)
	{
		$params = $request->all();
		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);

			return view('report.locsotiennguoichoilose', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
			$datachart[$i - 1]['vang'] = 0;
		}

		$log = new loggunclash();
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

		return view('report.locsotiennguoichoilose', compact('input', 'datachart'));
	}

	function getQuocgiacosologinnhieunhat(Request $request)
	{
		$params = $request->all();
		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);

			return view('report.quocgiacosologinnhieunhat', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		$log = new loggunclash();
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

		return view('report.quocgiacosologinnhieunhat', compact('input', 'datachart'));
	}

	function getLevelusermuainapp(Request $request)
	{
		$params = $request->all();

		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
			];
			$datachart = json_encode($datachart);
			return view('report.levelusermuainapp', compact('input', 'datachart'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new loggunclash();
		$loggunclash = $log->LocLevelUserMuaInapp($input)->get();

		foreach ($loggunclash as $item) {
			if ($item->level > 0) {
				$lv = $item->level;
				$datachart[$lv - 1]['soluong']++;
			}
		}

		$datachart = json_encode($datachart);

		return view('report.levelusermuainapp', compact('input', 'datachart'));
	}

	function getLogevent(Request $request)
	{
		$params = $request->all();

		$eventname = new eventname();
		$listEventname = $eventname->getListeventname();

		$log = new loggunclash();
		$listColumnLog = $log->getColumn();

		if (empty($params['time'])) {
			$input = [
				'eventname' => '',
				'week' => '',
				'time' => 'homnay',
			];
			return view('report.logevent', compact('input', 'listEventname', 'listColumnLog'));
		} else {
			$input = $params;
		}


		$loggunclash = $log->LogLogevent($input)->get();

		$logpagi = $loggunclash->paginate(50);

		return view('report.logevent', compact('input', 'logpagi', 'listEventname', 'listColumnLog'));
	}

	function test1()
	{
		//$log = new loggunclash();
		//$loggunclash = $log->testrandom();
		//$a = array_rand($loggunclash);

		//$test = config::createSingletonObject('zxc');
		//$test = config::createSingletonObject('zxc');
		//Config::set(['global.test' => 'zxc2323']);
		//$test = config('global.test');

		//$memcache = new Memcached();
		//$memcache ->addServer('localhost', 11211);
		//$memcache->set('a', 'test');
		//$test = $memcache->get('a');


		$arr[] = [
			'id' => 1,
			'value' => 'val 1'
		];
		$arr[] = [
			'id' => 2,
			'value' => 'val 2'
		];
		$arr[] = [
			'id' => 2,
			'value' => 'val 3'
		];
		$arr[] = [
			'id' => 2,
			'value' => 'val 4'
		];
		Cache::forever('key2', $arr);

		echo "<pre>";
		print_r(Cache::get('key2'));
		echo "</pre>";
	}

	function test2()
	{
		//$test = config::createSingletonObject('zxc1');
		//$test = config('global.test');

		$cache = Cache::get('key2');
		echo "<pre>";
		print_r(current($cache));
		echo "</pre>";
		echo "<pre>";
		print_r(key($cache));
		echo "</pre>";

		$cur_key = key($cache);
		$sophantuxoa = 5;
		array_splice($cache,$cur_key,$sophantuxoa);
		echo "<pre>";
		print_r($cache);
		echo "</pre>";

		/*$dem = 0;
		foreach ($cache as $key => $item) {
			$dem++;
			if ($dem < 3) {
				unset($cache[$key]);
			}
		}*/
		/*$cache[] = [
			'id' => 1,
			'value' => 'val 5'
		];
		$cache[] = [
			'id' => 2,
			'value' => 'val 6'
		];*/
		//Cache::forever('key2', $cache);

		echo "<pre>";
		print_r(Cache::get('key2'));
		echo "</pre>";

	}

	function test3()
	{
		//$test = config::createSingletonObject('zxc1');
		//$test = config('global.test');

		//Cache::forget('key2');
		$cache = Cache::get('key2');
		$cache[] = [
			'id' => 1,
			'value' => 'val 5'
		];
		$cache[] = [
			'id' => 2,
			'value' => 'val 6'
		];
		$cache[] = [
			'id' => 2,
			'value' => 'val 7'
		];
		$cache[] = [
			'id' => 2,
			'value' => 'val 8'
		];
		//array_shift($cache);
		Cache::forever('key2', $cache);

		echo "<pre>";
		print_r(Cache::get('key2'));
		echo "</pre>";

	}

}
