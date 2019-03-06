<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Usetrackers extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}
	protected $table = 'user_trackers';
	protected $guarded = ['id','created_at','updated_at'];
	
}