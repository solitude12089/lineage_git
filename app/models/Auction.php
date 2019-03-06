<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Auction extends Model
{
	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}

	
	protected $table = 'auction';
	protected $guarded = ['id'];


	public function details(){
		return $this->hasMany('App\models\Auction_detail',  'auction_id','id');
	}
}