<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class eventname extends Model
{
    protected $table = "eventname";
	public $timestamps = false;

	public function getListeventname(){
		$eventname = $this::get();

		return $eventname;
	}
}
