<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Treasure extends Model
{

	
	public function __construct()
	{

	    $this->connection = Auth::user()->customer->dbname;

	}
	protected $table = 'treasure';
	protected $guarded = ['id'];

	public function owner_name(){
		return $this->hasOne('\App\User', 'email', 'owner');
	}
	public function user(){
		return $this->hasOne('\App\User', 'email', 'user_id');
	}
	public function attachments(){
		return $this->hasOne('App\models\attachment',  'target_id','id')->where('type','treasure');
	}
	public function details(){
		return $this->hasMany('App\models\Treasure_detail',  'treasure_id','id');
	}
}