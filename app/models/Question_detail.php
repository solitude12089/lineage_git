<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Question_detail extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}
	protected $table = 'question_detail';
	protected $guarded = ['id'];

	protected $casts = [
		'option' => 'array'
	];
	
}