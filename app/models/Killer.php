<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Killer extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}
	protected $table = 'killer';
	protected $guarded = ['id'];

	public function user(){
		return $this->hasOne('\App\User', 'email', 'user_id');
	}
	public function attachments(){
		return $this->hasMany('App\models\attachment',  'target_id','id')->where('type','killer');
	}
}