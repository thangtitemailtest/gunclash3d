<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class config extends Model
{
    protected $table = "config";
	public $timestamps = false;

	public function getConfig(){
		$config = $this::first();

		return $config;
	}

	public function updateConfigDate(){
		$config = $this->getConfig();
		$config->updatedate = date('Y-m-d H:i:s');
		$config->save();

		return 1;
	}
}
