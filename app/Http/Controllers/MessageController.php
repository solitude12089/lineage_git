<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Log;
use Crypt;
use Hash;

class MessageController extends Controller
{

	public function getView($msg)
    {
        
    	
    	return view('layouts.msg',['msg'=>$msg]);
    }


}