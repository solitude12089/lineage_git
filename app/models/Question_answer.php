<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Question_answer extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}
	protected $table = 'question_answer';
	protected $guarded = ['id'];
	
}