<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Operation extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}
	protected $table = 'operation';
	protected $guarded = ['id'];

}