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

class GeneralController extends Controller
{

	public function getIndex()
    {
        $user=Auth::user();
        if (strpos($user->role_id, '3') === false && strpos($user->role_id, '4') === false) {
            return '無權限操作';
        }

        $users = \App\User::where('customer_id',Auth::user()->customer_id)
                        ->with('moneylogs')->where('status','!=',9)
                        ->get();

        $sum = \App\models\Moneylog::sum('amount');

        
        // dd($rt_user_list);
    
    	
    	return view('general.index',['users'=>$users ,'sum' => $sum]);
    }

    public function getInfo($user_id)
    {

        $user=Auth::user();
        $get_user = \App\User::where('customer_id',Auth::user()->customer_id)->where('id',$user_id)->first();
        $moneylogs = \App\models\Moneylog::with('treasure')
                                        ->where('user_id',$get_user->email)
                                        ->orderBy('created_at','desc')
                                        ->get();
        
        return view('general.info',['get_user'=>$get_user,'moneylogs'=>$moneylogs]);
    }

}