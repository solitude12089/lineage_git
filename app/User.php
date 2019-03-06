<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'lineagepublic';
    protected $fillable = [
        'name', 'email', 'password','job'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function moneylogs(){
        return $this->hasMany('\App\models\Moneylog',  'user_id','email');
    }

    public function customer(){
        return $this->hasOne('\App\models\Customer',  'id','customer_id');
    }

       
}
