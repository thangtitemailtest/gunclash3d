<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class Notification extends Controller
{
	public function sendNotiTest()
	{
		$info = [
			"priority" => "high",
			"notification" => [
				"title" => "Hey! Commander!555",
				"body" => "You have attacked by tên thằng đánh! Open game to view!",
				//"sound" => "default"
			],
			//"to" => "cNvdQrMiSnOnDUg6F5DJe-:APA91bFOV7sstv0HeDUdPku_L8P4S1FUoz-2AgaA6oHxYGEbPxSwcAKAnVz1Rkg_BGvbekhszBP4DtI5JHtdPBXHcs-r8gTp2r6MGk0BO5A5e8OwGT-H4nxQei402pP_d-rDbtynHr_K"
			"to" => "eT3sljdx3kRnvjRezMoLLx:APA91bHApygiZ0MbuihFhg2taxAALDKEMOqFQhIt1_TqgbBLWuJ_jxTpEazc9MuLEbBoErsr-pnuYXLOnAMYU_V9LRWq4YvjKaqr24OAUyE3YYGBzgeqDyLf0eEMyvqf7AsWA2Bt8mx3"
		];
		$sendinfo = json_encode($info);
		$ch = curl_init("https://fcm.googleapis.com/fcm/send");
		$header = array('Content-Type: application/json',
			"Authorization: key=AAAAGE0t6F0:APA91bFeOGyrCyCh172XGerOq-cdiVcoSd9wyq6eSBgFfwhqBTT_JQq2J5L8pmIIGdK49gnPFmpVPcBcFD5lPfpsstTRDMZ1jIEi7UHmWFkj8c3pzGVNJ9_FqhRKyCwLy9nQ853HauPc");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $sendinfo);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);

		echo $result;
	}

	//$userbidanh_gcm = "eT3sljdx3kRnvjRezMoLLx:APA91bHApygiZ0MbuihFhg2taxAALDKEMOqFQhIt1_TqgbBLWuJ_jxTpEazc9MuLEbBoErsr-pnuYXLOnAMYU_V9LRWq4YvjKaqr24OAUyE3YYGBzgeqDyLf0eEMyvqf7AsWA2Bt8mx3";
		//$userbidanh_gcm = "cNvdQrMiSnOnDUg6F5DJe-:APA91bFOV7sstv0HeDUdPku_L8P4S1FUoz-2AgaA6oHxYGEbPxSwcAKAnVz1Rkg_BGvbekhszBP4DtI5JHtdPBXHcs-r8gTp2r6MGk0BO5A5e8OwGT-H4nxQei402pP_d-rDbtynHr_K";

	public function sendNoti($platform, $to, $title, $body)
	{
		$info = [
			"priority" => "high",
			"notification" => [
				"title" => $title,
				"body" => $body,
				"sound" => "default"
			],
			"to" => $to
		];
		$sendinfo = json_encode($info);
		$ch = curl_init("https://fcm.googleapis.com/fcm/send");
		$serverkey = "";
		if ($platform == 'IOS' || $platform == 'ios') {
			$serverkey = "AAAAGE0t6F0:APA91bFeOGyrCyCh172XGerOq-cdiVcoSd9wyq6eSBgFfwhqBTT_JQq2J5L8pmIIGdK49gnPFmpVPcBcFD5lPfpsstTRDMZ1jIEi7UHmWFkj8c3pzGVNJ9_FqhRKyCwLy9nQ853HauPc";
		}
		if ($platform == 'ANDROID' || $platform == 'android') {
			$serverkey = "AAAAb_fccfs:APA91bFc08bhNsDslJE2NtBycHSDDNu385T98o6Zsoravxvtc2uguuQLYPDH2cMR2dlSKJ35CydtxMAUFQSo3TV4eqvvC6OJr0mu1eHGA7Rti-YXx9mjVtFev4Sc__Yxk1FlZOUR1C1Q";
		}
		$header = array('Content-Type: application/json',
			"Authorization: key=" . $serverkey . "");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $sendinfo);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}

}
