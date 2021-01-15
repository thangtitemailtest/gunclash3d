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
		'servicelogin', 'serviceupdatemyinfo', 'servicegetmytowerinfo', 'servicegetotherplayer', 'servicegetotherplayernew', 'serviceupdateotherplayertower', 'savelogs', 'servicegcmid', 'login-post', 'getlistattack', 'getlistrevenge', 'test',
		'gun2/servicelogin', 'gun2/serviceupdatemyinfo', 'gun2/servicegetmytowerinfo', 'gun2/servicegetotherplayer', 'gun2/servicegetotherplayernew', 'gun2/serviceupdateotherplayertower', 'gun2/savelogs', 'gun2/servicegcmid', 'gun2/getlistattack', 'gun2/getlistrevenge', 'gun2/test',
		'gun3/servicelogin', 'gun3/serviceupdatemyinfo', 'gun3/servicegetmytowerinfo', 'gun3/servicegetotherplayer', 'gun3/servicegetotherplayernew', 'gun3/serviceupdateotherplayertower', 'gun3/savelogs', 'gun3/servicegcmid', 'gun3/getlistattack', 'gun3/getlistrevenge', 'gun3/test',
	];
}
