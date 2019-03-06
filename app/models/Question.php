<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Question extends Model
{

	public function __construct()
	{
		$this->connection = Auth::user()->customer->dbname;
	}
	protected $table = 'question';
	protected $guarded = ['id'];
	public $timestamps = false;


	public function details(){
		return $this->hasMany('App\models\Question_detail',  'question_id','id')->orderby('sort','asc');
	}
	
}