<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class Notification extends Controller
{
	public function sendNoti($to = "", $title = "", $body = "")
	{
		$info = [
			"priority" => "high",
			"notification" => [
				"title" => $title,
				"body" => $body,
				//"sound" => "default"
			],
			"to" => $to
			//"to" => "fA6ilviQRDy_UIUuYiVhII:APA91bGWdO_gAhUgKpBGas3KjDUuGyfLaBAQUiuuG9moti1KIGHNVDCTf87Ik5h60pt2JPsr5_wz0Uf36L7zqf24087zOsIAP7h7fQjdCjMxkeN4ssP7LEVmpE3k9L50VuuNgxCFLHZf"
		];
		$sendinfo = json_encode($info);
		$ch = curl_init("https://fcm.googleapis.com/fcm/send");
		$header = array('Content-Type: application/json',
			"Authorization: key=AAAAb_fccfs:APA91bFc08bhNsDslJE2NtBycHSDDNu385T98o6Zsoravxvtc2uguuQLYPDH2cMR2dlSKJ35CydtxMAUFQSo3TV4eqvvC6OJr0mu1eHGA7Rti-YXx9mjVtFev4Sc__Yxk1FlZOUR1C1Q");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $sendinfo);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
	}

}
