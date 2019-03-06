<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

	protected $connection = 'lineagepublic';
	protected $table = 'job';
}