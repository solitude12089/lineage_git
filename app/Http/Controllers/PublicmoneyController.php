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

class PublicmoneyController extends Controller
{

	

	public function getIndex()
    {
    	$user=Auth::user();
    	$public_moneylogs = \App\models\Moneylog::with('treasure')
    									->where('user_id',$user->customer_id.'_公積金')
    									->orderBy('created_at','desc')
    									->get();

    	
    	return view('publicmoney.index',['public_moneylogs'=>$public_moneylogs]);
    }




    public function getAdd(){

        return view('publicmoney.add');
    }

    public function postAdd(Request $request){
        $user=Auth::user();
        if (strpos($user->role_id, '4') === false) {
            return '權限不足';
        }
        $data = $request->all();
        if(!isset($data['_amount'])){
             return '請輸入支出';
        }

        $mlog = new \App\models\Moneylog;
        $mlog ->source_type = $data['_reason'];
        $mlog ->source_id = 0;
        $mlog ->amount = -$data['_amount'];
        $mlog ->user_id = Auth::user()->customer_id.'_公積金';
        $mlog ->save();

        return back();

    }
                            
    public function getInfo($moneylog_id)
    {
    	
    	$user=Auth::user();
        $customer = $user->customer;
    	$boss_list = \App\models\Boss::all()->pluck('name','id');
    	$moneylog = \App\models\Moneylog::with('treasure')
    									->with('treasure.owner_name')
		    							->with('treasure.details')
		    							->with('treasure.details.user')
		    							->with('treasure.attachments')
		    							->where('id',$moneylog_id)
		    							->first();
    	
    	return view('publicmoney.info',['moneylog'=>$moneylog,'boss_list'=>$boss_list,'customer'=>$customer]);
    }

   

    
 	
 	
}