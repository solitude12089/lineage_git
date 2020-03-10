<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Log;



class OffsetController extends Controller
{
	public function getIndex()
    {
        $user=Auth::user();
        if (strpos($user->role_id, '4') === false) {
            return '無權限操作';
        }
    	$offsets = \App\models\Offset::with('user')
                                ->where('status',1)
    							->orderBy('created_at','desc')
    							->get();
    	return view('offset.index',['offsets'=>$offsets]);
    }

    public function getRequire($treasure_id)
    {

        $user=Auth::user();
        $treasure = \App\models\Treasure::with('details')
                                ->with('details.user')
                                ->with('attachments')
                                ->where('id',$treasure_id)
                                ->first();
        $boss_list = \App\models\Boss::all()->pluck('name','id');
        
        if($treasure->status==2){
            return '單據已入帳,無法申請';
        }
        if($treasure->owner!=$user->email){
            return '持有者非本人,無權限操作';
        }
        
        return view('offset.require',['treasure'=>$treasure,'boss_list'=>$boss_list]);
    }


    public function postRequire(Request $request,$treasure_id)
    {

        $user=Auth::user();
        $data = $request->all();


        $treasure = \App\models\Treasure::where('id',$treasure_id)
                                ->first();
       
        $fw = new \App\Http\Controllers\FileserverController;
        $new_note=new \App\models\Offset;
      
        $new_note->treasure_id=$treasure_id;
        $new_note->treasure_displayname = $treasure->no;
        $new_note->amount=$data['_amount'];
        $new_note->status=1;
        $new_note->user_id=$user->email;
        $new_note->save();


      
      
        if($request->file('_file')!=null)
        {
             $fw->upload($request->file('_file'),$new_note->id,'offset');
        }

        return view('layouts.msg',['msg' => '申請完成,等待審核']);
    }


                            
   

    
 	

    public function postDoconfirm(Request $request,$offset_id){
        try {
            DB::connection(Auth::user()->customer->dbname)->beginTransaction();
            $user = Auth::user();
            $customer = $user->customer;
            $data = $request->all();
            $date = date("Y-m-d H:i:s");

            $offset = \App\models\Offset::where('id',$offset_id)->first();
            $request_user =\App\User::where('customer_id',Auth::user()->customer_id)->where('email',$offset->user_id)->first();
           
            $treasure = \App\models\Treasure::with('user')
                                    ->with('details')
                                    ->where('id',$offset->treasure_id)
                                    ->first();

            if($treasure->status!=1){
                return $offset->treasure_displayname.'  單據狀態錯誤,無法入帳';
            }

            if($offset->amount>$request_user->moneylogs->sum('amount')){
                return "扣薪入帳失敗,".$offset->user_id." 餘額不足";
            }

           

            //扣帳
            $moneylog = new \App\models\Moneylog;
            $moneylog->source_type = $date." 扣薪入帳";
            $moneylog->source_id = $treasure->id;
            $moneylog->amount = -$offset->amount;
            $moneylog->user_id = $request_user->email;
            $moneylog->save();


            $treasure = \App\models\Treasure::with('user')
                                    ->with('details')
                                    ->where('id',$offset->treasure_id)
                                    ->first();
            
          
          
                $public_money =  (int)($offset->amount*$customer->treasure_public_scale/100);
                //$public_money =  (int)($data['really_price']*0.2);
                if($customer->keyin_bonus==1){
                     $avg = (int)($offset->amount*((100-$customer->treasure_public_scale)/100)/(count($treasure->details)+1));
                }
                else{
                     $avg = (int)($offset->amount*((100-$customer->treasure_public_scale)/100)/count($treasure->details));
                }
                //$avg = (int)($offset->amount*0.8/count($treasure->details));

                $treasure->really_price = $offset->amount;
                $treasure->status=2;
                $treasure->assentor = $user->email;
                $treasure->save();
                Log::info("Treasure_id : ".$treasure->id.' 扣薪入帳 '.$offset->amount.' by '.$user->name);
            
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
            $offset->status=2;
            $offset->assentor=$user->email;
            $offset->save();

            Log::info("Offset : ".$offset->id.' 扣薪入帳 '.$offset->amount.' 審核確認  by '.$user->name);







            DB::connection(Auth::user()->customer->dbname)->commit();

            
        } catch (Exception $e) {
            DB::connection(Auth::user()->customer->dbname)->rollBack();
            return $e;
        }
        

        return back();
    }

    public function postDoclose(Request $request,$offset_id){
        $user = Auth::user();
        $export = \App\models\Offset::where('id',$offset_id)->first();
        $export->delete();
        return back();
    }


    public function getPic($offset_id){
        $offset = \App\models\Offset::with('attachments')
                                    ->where('id',$offset_id)
                                    ->first();
                                    
        return view('offset.pic',['offset'=>$offset]);
    }
}