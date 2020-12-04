<?php

namespace App;

$GLOBALS['test'] = [];

class config
{
	private static $singletonObj = null;

	public static function createSingletonObject($value)
	{
		// Bước 3
		/*if (self::$singletonObj !== null) {
			return self::$singletonObj;
		}*/

		// Bước 2
		self::$singletonObj .= $value;
		return self::$singletonObj;
	}

	public function __construct($config_arr)
	{
	}
}
