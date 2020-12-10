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
		'servicelogin', 'serviceupdatemyinfo', 'servicegetmytowerinfo', 'servicegetotherplayer', 'serviceupdateotherplayertower', 'savelogs', 'servicegcmid', 'login-post',
		'gun2/servicelogin', 'gun2/serviceupdatemyinfo', 'gun2/servicegetmytowerinfo', 'gun2/servicegetotherplayer', 'gun2/serviceupdateotherplayertower', 'gun2/savelogs', 'gun2/servicegcmid',
	];
}
