<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class CrossTreasure_part extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->crossdb;
	}
	protected $table = 'cross_treasure_part';
	protected $guarded = ['id'];

	public function user(){
		return $this->hasOne('\App\User', 'email', 'user_id');
	}
	
}