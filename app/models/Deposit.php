<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Deposit extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}
	protected $table = 'deposit';
	protected $guarded = ['id'];

}