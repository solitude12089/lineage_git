<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Log;



class ExportController extends Controller
{
	public function getIndex()
    {
        $user=Auth::user();
        if (strpos($user->role_id, '4') === false) {
            return '權限不足';
        }
    	$exports = \App\models\Export::with('user')
                                ->where('status',1)
    							->orderBy('created_at','desc')
    							->get();
        $exports_history = \App\models\Export::with('user')
                                ->where('status',2)
                                ->orderBy('created_at','desc')
                                ->get();                
    	return view('export.index',['exports'=>$exports,'exports_history'=>$exports_history]);
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

   

    
 	
 	public function postDoexport(Request $request){
 		$user = Auth::user();
 		$data = $request->all();
        $date = date('Ymd');


        $request_user = \App\User::where('customer_id',Auth::user()->customer_id)->with('moneylogs')->where('email',$user->email)->first();

        if($data['amount']>$request_user->moneylogs->sum('amount')){
            return "提領失敗,餘額不足";
        }
       

        
        $first_note= \App\models\Export::where('no','like',"E".$date.'%')
                                    ->orderBy('no','desc')
                                    ->first();
        if($first_note)
        {
            $_no=(string)((substr($first_note->no, 1))+1);
        }
        else
        {
            $_no=$date.'0001';
        }

      

 		
        $export = new \App\models\Export;
        $export->user_id = $user->email;
        $export->amount=$data['amount'];
        $export->no = "E".$_no;
        $export->status = 1;
        $export->save();
        return view('export.exportSuccess');
        
 	}

    public function postDoconfirm(Request $request,$export_id){
        $user = Auth::user();
        $data = $request->all();
        $date = date("Y-m-d H:i:s");

        $export = \App\models\Export::where('id',$export_id)->first();
        $request_user = \App\User::where('customer_id',Auth::user()->customer_id)->with('moneylogs')->where('email',$export->user_id)->first();

        if($export->amount>$request_user->moneylogs->sum('amount')){
            return "提領失敗,餘額不足";
        }
        $export->status=2;
        $export->assentor=$user->email;
        $export->save();

        Log::info("Export : ".$export->id.' 提領 '.$export->amount.' 審核確認  by '.$user->name);

        $moneylog = new \App\models\Moneylog;
        $moneylog->source_type = $date." 提領";
        $moneylog->source_id = 0;
        $moneylog->amount = -$export->amount;
        $moneylog->user_id = $request_user->email;
        $moneylog->save();
   

        return back();
    }

    public function postDoclose(Request $request,$export_id){
        $user = Auth::user();
        $export = \App\models\Export::where('id',$export_id)->first();
        $export->delete();
        return back();
    }

}