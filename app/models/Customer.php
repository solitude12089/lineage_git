<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

	protected $connection = 'lineagepublic';
	protected $table = 'customer';
}