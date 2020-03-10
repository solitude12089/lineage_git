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

class GuildController extends Controller
{

	public function getIndex()
    {

        $user=Auth::user();
        if (strpos($user->role_id, '4') === false) {
            return '無權限操作';
        }
        $user_list = \App\User::where('status',1)
                            ->orderBy('job')
                            ->get();
        $guilds = \App\models\Guild::all();
        $rt_user_list = [];
        foreach ($user_list  as $key => $value) {
            $rt_user_list[$value->guild][] = $value;
        }
        // dd($rt_user_list);
    
    	
    	return view('guild.index',['user_list'=>$rt_user_list,'guilds'=>$guilds]);
    }

    public function postIndex(Request $request)
    {   
        $guilds = \App\models\Guild::all();
        $data = $request->all();
        //dd($data);
        foreach ($guilds as $key => $guild) {
            if(isset($data[$guild->name])){
                $gv = $data[$guild->name];
                foreach ($gv as $uk => $uv) {
                    $_user = \App\User::where('email',$uv)->first();
                    $_user->guild=$guild->name;
                    $_user->save();
                }

            }
        }
    }



                            
    public function getInfo($moneylog_id)
    {
    	
    	$user=Auth::user();
    	$boss_list = \App\models\Boss::all()->pluck('name','id');
    	$moneylog = \App\models\Moneylog::with('treasure')
    									->with('treasure.owner_name')
		    							->with('treasure.details')
		    							->with('treasure.details.user')
		    							->with('treasure.attachments')
		    							->where('id',$moneylog_id)
		    							->first();
    	
    	return view('self.info',['moneylog'=>$moneylog,'boss_list'=>$boss_list]);
    }

   

    
 	
 	// public function postDoimport(Request $request,$treasure_id){
 	// 	$user = Auth::user();
 	// 	$data = $request->all();
 	// 	$treasure = \App\models\Treasure::with('user')
 	// 								->with('details')
 	// 								->where('id',$treasure_id)
 	// 								->first();
 	// 	if($treasure->status!=1)
 	// 	{
 	// 		return "此單號已經入帳 , 入帳失敗";
 	// 	}
 	// 	$public_money =  (int)($data['really_price']*0.2);
		// $avg = (int)($data['really_price']*0.8/count($treasure->details));

 	// 	$treasure->really_price = $data['really_price'];
 	// 	$treasure->status=2;
 	// 	$treasure->save();
 	// 	Log::info("Treasure_id : ".$treasure->id.' 入帳 '.$data['really_price'].' by '.$user->name);
 	
 	// 	foreach ($treasure->details as $key => $value) {
 	// 		$mlog = new \App\models\Moneylog;
 	// 		$mlog ->source_type = 'treasure';
 	// 		$mlog ->source_id = $treasure->id;
 	// 		$mlog ->amount = $avg;
 	// 		$mlog ->user_id = $value->user_id;
 	// 		$mlog ->save();
 	// 	}
 	// 	$mlog = new \App\models\Moneylog;
		// $mlog ->source_type = 'treasure';
		// $mlog ->source_id = $treasure->id;
		// $mlog ->amount = $public_money;
		// $mlog ->user_id = 'admin';
		// $mlog ->save();


 	// 	return redirect('import/index');
 	// }
}