<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Treasure_detail extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}
	protected $table = 'treasure_detail';
	protected $guarded = ['id'];

	public function user(){
		return $this->hasOne('\App\User', 'email', 'user_id');
	}
	
}