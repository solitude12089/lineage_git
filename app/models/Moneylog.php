<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Moneylog extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}
	protected $table = 'money_log';
	protected $guarded = ['id'];
	
	public function treasure(){
		return $this->hasOne('App\models\Treasure',  'id','source_id');
	}
}