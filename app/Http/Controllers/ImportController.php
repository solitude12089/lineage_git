<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Log;


class ImportController extends Controller
{
	public function getIndex()
    {
    	$user=Auth::user();
        if (strpos($user->role_id, '4') === false) {
            return '無權限操作';
        }
    	$now = date("Y-m-d H:i:s");
        $user_map = \App\User::where('customer_id',Auth::user()->customer_id)
         ->where('status','!=',2)
         ->get()
         ->pluck('name','email')->toArray();
    

    	
    	$boss_list = \App\models\Boss::all()->pluck('name','id');
    	$treasures = \App\models\Treasure::with('user')
    							->with('owner_name')
    							->with('details')
    							->with('details.user')
    							->with('attachments')
    							->whereRaw("DATE_ADD(created_at, INTERVAL 1 DAY) <= '".$now."' and status ='1'" )
    							->orderBy('created_at','desc')
    							->get();
        $history_treasures = \App\models\Treasure::with('user')
                                ->with('owner_name')
                                ->with('details')
                                ->with('details.user')
                                ->with('attachments')
                                ->where("status","2")
                                ->orderBy('created_at','desc')
                                ->get();

    	foreach ($treasures as $key => $value) {
    		foreach ($value->details as $k => $v) {
			 	if($k==0){
			 		$value->d_string=$value->d_string.$v->user->name;
			 	}
			 	else{
			 		$value->d_string=$value->d_string.','.$v->user->name;
			 	}
    		}
    	}
        foreach ($history_treasures as $key => $value) {
            foreach ($value->details as $k => $v) {
                if($k==0){
                    $value->d_string=$value->d_string.$v->user->name;
                }
                else{
                    $value->d_string=$value->d_string.','.$v->user->name;
                }
            }
        }
    	return view('import.index',[
            'treasures'=>$treasures,
            'boss_list'=>$boss_list,
            'history_treasures'=>$history_treasures,
            'user_map'=>$user_map
            ]);
    }



                            
    public function getInfo($treasure_id)
    {
    	
    	$user=Auth::user();
    	$boss_list = \App\models\Boss::all()->pluck('name','id');
       
    	$treasure = \App\models\Treasure::with('user')
    							->with('owner_name')
    							->with('details')
    							->with('details.user')
    							->with('attachments')
    							->where('id',$treasure_id)
    							->first();
    	return view('import.info',['treasure'=>$treasure,'boss_list'=>$boss_list]);
    }

    public function getInfohistory($treasure_id)
    {
        
        $user=Auth::user();
        $user_map = \App\User::where('customer_id',Auth::user()->customer_id)
         ->where('status','!=',2)
         ->get()
         ->pluck('name','email')->toArray();
        $boss_list = \App\models\Boss::all()->pluck('name','id');
        $treasure = \App\models\Treasure::with('user')
                                ->with('owner_name')
                                ->with('details')
                                ->with('details.user')
                                ->with('attachments')
                                ->where('id',$treasure_id)
                                ->first();
        return view('import.infohistory',['treasure'=>$treasure,'boss_list'=>$boss_list,'user_map'=>$user_map]);
    }

   

    
 	
 	public function postDoimport(Request $request,$treasure_id){
 		$user = Auth::user();
        if (strpos($user->role_id, '4') === false) {
            return '無權限操作';
        }
        $customer = $user->customer;
 		$data = $request->all();
 		$treasure = \App\models\Treasure::with('user')
 									->with('details')
 									->where('id',$treasure_id)
 									->first();
 		if($treasure->status!=1)
 		{
 			return "此單號已經入帳 , 入帳失敗";
 		}
      
        // if($treasure->day >= '2018-06-18'){

            // $avg = (int)($data['really_price']/count($treasure->details));
            // $treasure->really_price = $data['really_price'];
            // $treasure->status=2;
            // $treasure->assentor = $user->email;
            // $treasure->save();
            // Log::info("Treasure_id : ".$treasure->id.' 入帳 '.$data['really_price'].' by '.$user->name);
        
            // foreach ($treasure->details as $key => $value) {
            //     $mlog = new \App\models\Moneylog;
            //     $mlog ->source_type = 'treasure';
            //     $mlog ->from_type = 1;
            //     $mlog ->source_id = $treasure->id;
            //     $mlog ->amount = $avg;
            //     $mlog ->user_id = $value->user_id;
            //     $mlog ->save();
            // }
        // }
        // else{
            $public_money =  (int)($data['really_price']*$customer->treasure_public_scale/100);
            if($customer->keyin_bonus==1){
                 $avg = (int)($data['really_price']*((100-$customer->treasure_public_scale)/100)/(count($treasure->details)+1));
            }
            else{
                 $avg = (int)($data['really_price']*((100-$customer->treasure_public_scale)/100)/count($treasure->details));
            }
           

            $treasure->really_price = $data['really_price'];
            $treasure->status=2;
            $treasure->assentor = $user->email;
            $treasure->save();
            Log::info("Treasure_id : ".$treasure->id.' 入帳 '.$data['really_price'].' by '.$user->name);
        
            foreach ($treasure->details as $key => $value) {
                $mlog = new \App\models\Moneylog;
                $mlog ->source_type = 'treasure';
                $mlog ->from_type = 1;
                $mlog ->source_id = $treasure->id;
                $mlog ->amount = $avg;
                $mlog ->user_id = $value->user_id;
                $mlog ->save();
            }
            if($customer->keyin_bonus==1){
                $blog = new \App\models\Moneylog;
                $blog ->source_type = '寶物單 '.$treasure->no .'KeyIN 獎勵';
                $blog ->from_type = 1;
                $blog ->source_id = $treasure->id;
                $blog ->amount = $avg;
                $blog ->user_id = $treasure->user_id;
                $blog ->save();
            }
            $mlog = new \App\models\Moneylog;
            $mlog ->source_type = 'treasure';
            $mlog ->from_type = 1;
            $mlog ->source_id = $treasure->id;
            $mlog ->amount = $public_money;
            $mlog ->user_id = Auth::user()->customer_id.'_公積金';
            $mlog ->save();
        // }
 		


 		return redirect('import/index');
 	}

    public function postDorollback(Request $request,$treasure_id){
        $user = Auth::user();
        if (strpos($user->role_id, '5') === false) {
            return '無權限操作';
        }

        $treasure = \App\models\Treasure::where('id',$treasure_id)
                                        ->first();
        $treasure->really_price = 0;
        $treasure->status = 1;
        $mlog = \App\models\Moneylog::where('source_id',$treasure->id)
                                    ->delete();
        $treasure->save();
        return redirect(url('/import/info/').'/'.$treasure_id);
    }
}