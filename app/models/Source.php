<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Source extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}
	protected $table = 'source';
}