<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class bookRelative extends Model
{
    //
	//use SoftDeletes;
	protected $connection = 'other';
	public $table = 'book_relative';
	public $timestamps = false;
	protected $guarded = [];


	public function Book()
	{
		return $this->hasOne('\App\models\bookTable', 'id', 'child_id');
	}

}
