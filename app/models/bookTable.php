<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class bookTable extends Model
{
    //
	//use SoftDeletes;
	protected $connection = 'other';
	public $table = 'book_table';
	public $timestamps = false;
	protected $guarded = [];
	
	

	public function relatives()
	{
		return $this->hasMany('\App\models\bookRelative', 'book_id', 'id');
	}
}
