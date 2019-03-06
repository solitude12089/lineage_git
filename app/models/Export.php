<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Export extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}
	protected $table = 'export_log';
	protected $guarded = ['id'];

	
	public function user(){
		return $this->hasOne('\App\User', 'email', 'user_id');
	}
	public function assentor_uesr(){
		return $this->hasOne('\App\User', 'email', 'assentor');
	}

	
}