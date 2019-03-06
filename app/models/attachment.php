<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class attachment extends Model
{
	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}

	
	protected $table = 'attachments';
	protected $guarded = ['id'];
}