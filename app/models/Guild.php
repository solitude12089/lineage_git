<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Guild extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}
	protected $table = 'guild';
}