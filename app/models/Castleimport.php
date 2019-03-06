<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Castleimport extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}
	protected $table = 'castle_import';
}