<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;


class RankController extends Controller
{
	public function getIndex()
    {

        $special = [];
        $user=Auth::user();
        $rank = 0 ;
        $table = DB::connection(Auth::user()->customer->dbname)->select("CALL Get_Rank()");
        foreach ($table as $key => $value) {
            $rank = $rank +1;
            $value->rank = $rank ;
        }
     
        
        return view('rank.index',['table'=>$table,'special'=>$special,'user'=>$user]);

       
 
    }



    public function getTreasureInfo($moneylog_id){
        $user=Auth::user();
        $boss_list = \App\models\Boss::all()->pluck('name','id');
        $moneylog = \App\models\Moneylog::with('treasure')
                                        ->with('treasure.owner_name')
                                        ->with('treasure.details')
                                        ->with('treasure.details.user')
                                        ->with('treasure.attachments')
                                        ->where('id',$moneylog_id)
                                        ->first();
        
        return view('rank.treasure_info',['moneylog'=>$moneylog,'boss_list'=>$boss_list]);;
    }

    
    public function getInfoList($user_id){


        //treasure
        $treasure_sql = "SELECT ml.id,t.no,t.day,t.item,ml.amount 
                FROM money_log as ml join treasure as t on ml.source_id = t.id 
                where t.day >= '2018-07-20'  and ml.from_type = 1 and ml.user_id = '".$user_id."' order by t.day desc";
        $treasure_table = DB::connection(Auth::user()->customer->dbname)->select($treasure_sql);

        $treasure_sum = 0;
        foreach($treasure_table as $key=>$value){
          if(isset($value->amount))
             $treasure_sum += $value->amount;
        }


        //killer
        $killer_sql = "SELECT ml.source_type,ml.amount,ml.created_at
                FROM money_log as ml
                where ml.from_type = 2 and ml.created_at >= '2018-07-20 00:00:00' and ml.user_id = '".$user_id."' order by ml.created_at desc";
        $killer_table = DB::connection(Auth::user()->customer->dbname)->select($killer_sql);

        $killer_sum = 0;
        foreach($killer_table as $key=>$value){
          if(isset($value->amount))
             $killer_sum += $value->amount*1.3;
        }

        //castle
        $castle_sql = "SELECT ml.source_type,ml.amount,ml.created_at
                FROM money_log as ml
                where ml.from_type = 3 and ml.created_at >= '2018-07-20 00:00:00' and ml.user_id = '".$user_id."' order by ml.created_at desc";
        $castle_table = DB::connection(Auth::user()->customer->dbname)->select($castle_sql);

        $castle_sum = 0;
        foreach($castle_table as $key=>$value){
          if(isset($value->amount))
             $castle_sum += $value->amount*3;
        }


        //other

        $other_sql = "SELECT sc.source_type,sc.amount,sc.created_at
                FROM other_score as sc
                where sc.user_id = '".$user_id."' order by sc.created_at desc";
              
        $other_table = DB::connection(Auth::user()->customer->dbname)->select($other_sql);

        $other_sum = 0;
        foreach($other_table as $key=>$value){
          if(isset($value->amount))
             $other_sum += $value->amount;
        }


        return view('rank.info_list',[
            'user_id'=>$user_id,
            'treasure_table'=>$treasure_table,
            'treasure_sum'=>$treasure_sum,
            'killer_table'=>$killer_table,
            'killer_sum'=>$killer_sum,
            'castle_table'=>$castle_table,
            'castle_sum'=>$castle_sum,
            'other_table'=>$other_table,
            'other_sum'=>$other_sum,
        ]);
    }
   

    public function getAdd(){
        $user=Auth::user();

        if(strpos(Auth::user()->role_id, '4') === false){
            return '權限不足';
        }
       
        $user_list = \App\User::where('status',1)->where('customer_id',Auth::user()->customer_id)->get();
       
        return view('rank.add',['user_list'=>$user_list]);

    }

    public function postAdd(Request $request){
        $user=Auth::user();

        if (strpos($user->role_id, '4') !== true) {
            return '權限不足';
        }
        $data = $request->all();
        $other_score = new \App\models\Otherscore;
        $other_score->source_type = $data['_source_type'];
        $other_score->amount = $data['_amount'];
        $other_score->user_id = $data['_user_id'];
        $other_score->save();

        return back();
      

    }
   
   
    
}