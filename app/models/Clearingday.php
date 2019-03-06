<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Clearingday extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}
	protected $table = 'clearing_day';
	public $timestamps = false;

}