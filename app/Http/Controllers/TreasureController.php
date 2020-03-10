<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;


class TreasureController extends Controller
{
	public function getIndex()
    {
    	$user=Auth::user();
    	$now = date("Y-m-d H:i:s");

    	
    	$boss_list = \App\models\Boss::all()->pluck('name','id');
    	$treasures = \App\models\Treasure::with('user')
    							->with('owner_name')
    							->with('details')
    							->with('details.user')
    							->with('attachments')
                                ->where('status',"1")
    							->orderBy('created_at','desc')
    							->get();

    	foreach ($treasures as $key => $value) {
    		$value->is_join = false;
    		if(date('Y-m-d H:i:s',strtotime($value->created_at . '+1 days')) >date("Y-m-d H:i:s")){
    			$value->show_time = true;
    		}
    		else{
    			$value->show_time = false;
    		}
    		foreach ($value->details as $k => $v) {
    			if($v->user_id==$user->email)
    			{
    				$value->is_join = true;
    			}
			 	if($k==0){
			 		$value->d_string=$value->d_string.$v->user->name;
			 	}
			 	else{
			 		$value->d_string=$value->d_string.','.$v->user->name;
			 	}
    		}
    	}
    	return view('treasure.index',['treasures'=>$treasures,'boss_list'=>$boss_list]);
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

        if(!$treasure){
            return view('layouts.msg',['msg'=>'找不到該單據號碼']);
        }
        $now = date("Y-m-d H:i:s");

    	$treasure->is_join = false;
        $treasure->is_complement = false;
    	foreach ($treasure->details as $k => $v) {
    			if($v->user_id==$user->email)
    			{
    				$treasure->is_join = true;
    			}
                if($v->type==2&&$v->user_id==$user->email){
                    $treasure->is_complement = true;
                }
		}

    	return view('treasure.info',['user'=>$user,'treasure'=>$treasure,'boss_list'=>$boss_list,'now'=>$now]);
    }

    public function getJoin($treasure_id)
    {

    	$user=Auth::user();
    	$treasure = \App\models\Treasure::with('user')
    							->where('id',$treasure_id)
    							->first();

        $details = \App\models\Treasure_detail::where('treasure_id',$treasure_id)
                                                ->where('user_id' , $user->email) 
                                                ->first();

        if($details==null){
            $details =new \App\models\Treasure_detail;
            $details->treasure_id = $treasure_id;
            $details->user_id = $user->email;
        }
        $details->type=2;
    	$details->save();
    	return back();
    }

    public function getUnjoin($treasure_id)
    {

        $user=Auth::user();
        $detail = \App\models\Treasure_detail::where('treasure_id',$treasure_id)
                                                ->where('user_id' ,$user->email)
                                                ->where('type',2)
                                                ->first();

        if($detail!=null){
             $detail->delete();        
        }
        return back();
    }


    public function getDelete($treasure_id){
        $user=Auth::user();
        if (strpos($user->role_id, '5') === false) {
            return '無權限操作';
        }
        $treasure = \App\models\Treasure::with('user')
                                ->where('id',$treasure_id)
                                ->first();
        $detail = \App\models\Treasure_detail::where('treasure_id',$treasure_id)
                                                ->get();
        $moneylog = \App\models\Moneylog::where('source_id',$treasure_id)
                                                ->get();
       
        $offset = \App\models\Offset::where('treasure_id',$treasure_id)
                                        ->first();

        if($treasure){
            $treasure->delete();
        }
        foreach ($detail as $key => $value) {
            $value->delete();
        }
        foreach ($moneylog as $key => $value) {
            $value->delete();
        }
        if($offset){
            $offset->delete();
        }


        return view('layouts.msg',['msg' => '刪除成功']);
       

    }





    public function getAdd()
    {
    	$user=Auth::user();
    	if($user==null){
    		return "error";
    	}
    	$user_list = \App\User::where('customer_id',Auth::user()->customer_id)->where('status',1)->get();
        $boss_list = \App\models\Boss::all()->pluck('name','id');

        foreach ($user_list as $key => $value) {
            $bygroup[$value->guild][]=$value;
        }

    	return view('treasure.add',['boss_list'=>$boss_list,'user_list'=>$user_list,'bygroup'=>$bygroup]);
    }

    public function getTestAdd()
    {
        $user=Auth::user();
        if($user==null){
            return "error";
        }
        $user_list = \App\User::where('customer_id',Auth::user()->customer_id)->where('status',1)->get();
        $boss_list = \App\models\Boss::all()->pluck('name','id');

        foreach ($user_list as $key => $value) {
            $bygroup[$value->guild][]=$value;
        }

        return view('treasure.add',['boss_list'=>$boss_list,'user_list'=>$user_list,'bygroup'=>$bygroup]);
    }



    public function getA(){
         $user_map = \App\User::where('customer_id',Auth::user()->customer_id)
         ->where('status',1)
         ->get()
         ->pluck('name','email')->toArray();
         dd($user_map);
    }





 	public function postAdd(Request $request)
    {

    	$user=Auth::user();
        $boss_list = \App\models\Boss::all()->pluck('name','id');
    	if($user==null){
    		return "error";
    	}

    	$fw = new \App\Http\Controllers\FileserverController;
        $date = date('Ymd');
        $data=$request->all();

        $user_map = \App\User::where('customer_id',Auth::user()->customer_id)
                 ->where('status',1)
                 ->get()
                 ->pluck('name','email')->toArray();
        $new_id = [];

       // dd($data['_item']);

        foreach ($data['_item'] as $item_key => $item_value) {
            if(strlen($item_value)==0)
                continue;

            $first_note= \App\models\Treasure::where('no','like',"T".$date.'%')
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
         

            $new_note=new \App\models\Treasure;
            $new_note->no="T".$_no;
            $new_note->boss_id=$data['_boss_id'];
            $new_note->day=$data['_day'].' '.$data['_time'];
            $new_note->item=$data['_item'][$item_key];
         	$new_note->owner=$data['_owner'][$item_key];
            $new_note->user_id=$user->email;
            $new_note->save();
            $new_id[] = $new_note->id;


            // if(!in_array($data['_owner'],$data['_members']))
            // {
            //     array_push($data['_members'], $data['_owner']);
            // }
            $msg_members = '';
            //memenber
            if(isset($data['_members'])){
            	foreach ($data['_members'] as $k => $v) {
            		$dtl=new \App\models\Treasure_detail;
    		        $dtl->treasure_id=$new_note->id;
    		        $dtl->user_id=$v;
    		        $dtl->type=1;
    		        $dtl->save();
                    $msg_members = $msg_members." ".$user_map[$v];
            	}
            }
            



            // $access_token = 'w46zv1AA5OInQkHfpdeEmsiFxZZoHB7Dnu4IzqdafvNlR8YkcAj5NEEpUEdCAhkOEnJMLa7TPpqAjlrj2FIK8wpAmTULdlx4j+6/6iFV2pGu7jptjml0dx+MLAUIAG0byKAXZCaXct58t2CLSSEb+wdB04t89/1O/w1cDnyilFU=';
            // $secret = '42b890d42af676ea08830dd8cb9660d3';

            // $customer = \App\models\customer::where('id',$user->customer_id)
            //                             ->first();

            // $access_token = '8L7+iU4Wj9pn+0/+Qii7IoMNT7JhHK450WGwnBSNyc+0ndKH3++M9kkqHUtiqQQra8/OTguNeI2o+C8bJ7/lY+0H+pUHp1LFl6mLUVREFvmahvFdi0k5CIN12mZVkDXOxuIBF1whwoamYmg+ILOe/wdB04t89/1O/w1cDnyilFU=';
            // $secret = '47a50c9a7742bc5dacfcc5b166316e91';

            // $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
            // $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $secret]);
            $msg=$user->name." 建立了寶物申報單 ".$new_note->no." 
日期：".$new_note->day." 
Boss：".$boss_list[$new_note->boss_id]." 
寶物：".preg_replace('/[\d]/','*',$new_note->item)." 
持有人：".$user_map[$new_note->owner]." 
參與人：".$msg_members." 
http://www.lineagebank.tw/treasure/info/".$new_note->id;
            // $content = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($msg);
            // $bot->pushMessage($customer->line_id, $content);

            $linetools = new \App\Http\Controllers\Tools\LineTools;
            $linetools->push($msg);


        }

        if($request->file('_file')!=null)
        {
            foreach ($request->file('_file') as $key => $value) {
                if($value)
                {
                    $fw->upload_m($value,$new_id,'treasure');
                }
            }
        }
       
        return back();
    }


 	public function getPic($treasure_id){
 		$treasure = \App\models\Treasure::with('user')
 									->with('attachments')
 									->where('id',$treasure_id)
 									->first();

 		return view('treasure.pic',['treasure'=>$treasure]);
 	}



    public function getReminder(){

        $now_sub_one = date('Y-m-d H:i:s',strtotime(date("Y-m-d H:i:s") . '-1 days'));
        $boss_list = \App\models\Boss::all()->pluck('name','id');
        $treasure = \App\models\treasure::where('status',1)
                ->where('created_at','<',$now_sub_one)
                ->orderBy('owner','asc')
                ->get();
        $user_map = \App\User::where('customer_id',Auth::user()->customer_id)
         ->get()
         ->pluck('name','email')->toArray();

        echo "尚未入帳名單,請盡速賣出入帳 謝謝!</br>";
        foreach ($treasure as $key => $value) {
            echo $user_map[$value->owner].'  '.$value->day.' '.$boss_list[$value->boss_id].' '.$value->item.'('.$value->no.')'.'</br>' ;
        }
        // dd($treasure);
    }

  


   
    public function getEdit($treasure_id)
    {
        
        $user=Auth::user();
        $user_list = \App\User::where('customer_id',Auth::user()->customer_id)->where('status',1)->get();
        $boss_list = \App\models\Boss::all()->pluck('name','id');
        $treasure = \App\models\Treasure::with('user')
                                ->with('owner_name')
                                ->with('details')
                                ->with('details.user')
                                ->with('attachments')
                                ->where('id',$treasure_id)
                                ->first();
        $treasure_details = \App\models\Treasure_detail::where('treasure_id',$treasure_id)
                                                        ->where('type',1)
                                                        ->get()
                                                        ->pluck('user_id')
                                                        ->toArray();
        foreach ($user_list as $key => $value) {
            $bygroup[$value->guild][]=$value;
        }
        return view('treasure.edit',['bygroup'=>$bygroup,'treasure'=>$treasure,'boss_list'=>$boss_list,'user_list'=>$user_list,'treasure_details'=>$treasure_details]);
    }


   
    public function postEdit(Request $request,$treasure_id)
    {
        
        $user=Auth::user();
        $data = $request->all();
        $treasure = \App\models\Treasure::with('user')
                                        ->where('id',$treasure_id)
                                        ->first();

        $treasure->item = $data['_item'];
        $treasure->boss_id = $data['_boss_id'];
        $treasure->owner = $data['_owner'];
        $treasure->save(); 

        if(isset($data['_members'])){
            $treasure_details = \App\models\Treasure_detail::where('treasure_id',$treasure_id)
                                                        ->where('type',1)
                                                        ->delete();
            foreach ($data['_members'] as $k => $v) {
                        $dtl=new \App\models\Treasure_detail;
                        $dtl->treasure_id=$treasure->id;
                        $dtl->user_id=$v;
                        $dtl->type=1;
                        $dtl->save();
            }
        }
       
        return redirect('treasure/info/'.$treasure_id); 
    }













}