<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
	/**
	 * The URIs that should be excluded from CSRF verification.
	 *
	 * @var array
	 */
	protected $except = [
		'servicelogin', 'serviceupdatemyinfo', 'servicegetmytowerinfo', 'servicegetotherplayer', 'servicegetotherplayernew', 'serviceupdateotherplayertower', 'savelogs', 'servicegcmid', 'login-post', 'getlistattack', 'getlistrevenge',
		'gun2/servicelogin', 'gun2/serviceupdatemyinfo', 'gun2/servicegetmytowerinfo', 'gun2/servicegetotherplayer', 'gun2/servicegetotherplayernew', 'gun2/serviceupdateotherplayertower', 'gun2/savelogs', 'gun2/servicegcmid', 'gun2/getlistattack', 'gun2/getlistrevenge',
	];
}
