<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

	protected $connection = 'lineagepublic';
	protected $table = 'role';
	protected $guarded = ['id'];
	
}