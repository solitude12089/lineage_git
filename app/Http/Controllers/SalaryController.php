<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;


class SalaryController extends Controller
{
	public function getIndex()
    {
        $user=Auth::user();
        if (strpos($user->role_id, '3') === false) {
            return '無權限操作';
        }
        $customer = $user->customer;
    	$clearing_day = \App\models\Clearingday::first();
        $salary_log = \App\models\Salarylog::all();
    	return view('salary.index',['clearing_day'=>$clearing_day,'salary_log'=>$salary_log,'customer'=>$customer]);
    }

    // public function getTrial()
    // {
    // 	$user=Auth::user();



    //     $start_day = \App\models\Clearingday::first()->day;

    //     $question = \App\models\Question::where('start_day','>',$start_day)->first();
    //     $memember_count =  \App\models\Question_answer::where('question_id',$question->id)->count();
       
    //     $end_day = date('Y-m-d', strtotime($start_day . ' +7 day'));
    //     $publicer = \App\User::with('moneylogs')->where('email','admin')->first();
    //     $public_money = $publicer->moneylogs->sum('amount');

    //     $killer_money = (int)($public_money*0.4);
    //     $salary_money = (int)($public_money*0.4);
    //     $reserve_money = (int)($public_money*0.2);

    //     //$memember_count = \App\User::where('status',1)->count();
    //     $memember_salary = (int)($salary_money/$memember_count);
    //     $killer_count = \App\models\Killer::where('date','>=',$start_day)
    //                                     ->where('date','<',$end_day)
    //                                     ->where('status',1)
    //                                     ->get()
    //                                     ->sum('qty');
    //     $killer_salary = (int)($killer_money/$killer_count);                        
        
    //     $lave =  $public_money - $reserve_money - $memember_salary*$memember_count - $killer_count*$killer_salary;
    // 	return view('salary.trial',compact('start_day','end_day','public_money','killer_money','salary_money','reserve_money','memember_count','memember_salary','killer_count','killer_salary','lave'));
    // }

    public function getTrial()
    {
        $user=Auth::user();
        if (strpos($user->role_id, '5') === false) {
            return '無權限操作';
        }

        
        $start_day = \App\models\Clearingday::first();
        if($start_day==null){
            $start_day = date('Y-m-d');
        }else
        {
            $start_day = $start_day->day;
        }


        $end_day = date('Y-m-d', strtotime($start_day . ' +7 day'));

        $Castleimport = \App\models\Castleimport::where('day','>=',$start_day)
                                                 ->where('day','<',$end_day)
                                                 ->first();
        if($Castleimport==null){
            return '尚未取得本週城鑽';
        }
      
        $group_sup =  0;

        $Castleimport->qty = $Castleimport->qty-0;

        $question = \App\models\Question::where('start_day','>',$start_day)->where('type',1)->first();
        if($question!=null){
            $memember_count =  \App\models\Question_answer::where('question_id',$question->id)->count();
            $memember_count_yes = \App\models\Question_answer::where('question_id',$question->id)
                                                        ->where('col1','會')->count();
        }
        else{
            $memember_count = 0;
            $memember_count_yes = 0;
        }
       
       
        $mercenary_count = $Castleimport->mercenary;
        $memember_point = $memember_count + $memember_count_yes + $mercenary_count*2 ;
        //dd($memember_count,$memember_count_yes,$memember_point);
        // $publicer = \App\User::with('moneylogs')->where('email','admin')->first();
        // $public_money = $publicer->moneylogs->sum('amount');

        $customer = $user->customer;
        $killer_money = (int)($Castleimport->qty*$customer->kill_scale/100);
        $salary_money = (int)($Castleimport->qty*$customer->member_scale/100);
        $public_money_o = (int)($Castleimport->qty*$customer->public_scale/100);

//        dd($killer_money,$salary_money,$public_money);

        //$memember_count = \App\User::where('status',1)->count();
        if($memember_point != 0){
            $memember_salary = (int)($salary_money/$memember_point);
        }else{
            $memember_salary = 0 ;
        }
        
        $killer_count = \App\models\Killer::where('date','>=',$start_day)
                                        ->where('date','<',$end_day)
                                        ->where('status',1)
                                        ->get()
                                        ->sum('qty');
        if($killer_count!=0){
            $killer_salary = (int)($killer_money/$killer_count);
        }else{
            $killer_salary = 0 ;
        }                  
        

       
        $lave =  $Castleimport->qty - $public_money_o - $memember_salary*$memember_point - $killer_count*$killer_salary;

        if($lave<0){
            return '剩餘金額<0  error 106';
        }

        $public_money = $public_money_o + $lave;
        //dd($public_money+($memember_salary*$memember_point)+($killer_count*$killer_salary));

        return view('salary.trial',compact('customer','start_day','end_day','Castleimport','killer_money','salary_money','memember_count','mercenary_count','memember_count_yes','public_money_o','public_money','memember_point','memember_salary','killer_count','killer_salary','lave'));
    }


    public function postTrial()
    {
        $user=Auth::user();
        if (strpos($user->role_id, '5') === false) {
            return '無權限操作';
        }
        try {
            DB::connection(Auth::user()->customer->dbname)->beginTransaction();
            $start_day = \App\models\Clearingday::first();
            if($start_day==null){
                $start_day = date('Y-m-d');
            }else
            {
                $start_day = $start_day->day;
            }


            $end_day = date('Y-m-d', strtotime($start_day . ' +7 day'));

            $Castleimport = \App\models\Castleimport::where('day','>=',$start_day)
                                                     ->where('day','<',$end_day)
                                                     ->first();
            if($Castleimport==null){
                return '尚未取得本週城鑽';
            }
            $original_Castleimport = $Castleimport->qty;
            
            $group_sup =  0;
            $Castleimport->qty = $Castleimport->qty-$group_sup;

            $Castleimport->qty = $Castleimport->qty-$group_sup;

            $question = \App\models\Question::where('start_day','>',$start_day)->where('type',1)->first();
            if($question!=null){
                $memember_count =  \App\models\Question_answer::where('question_id',$question->id)->count();
                $memember_count_yes = \App\models\Question_answer::where('question_id',$question->id)
                                                            ->where('col1','會')->count();
            }
            else{
                $memember_count = 0;
                $memember_count_yes = 0;
            }
           
           
            $mercenary_count = $Castleimport->mercenary;
            $memember_point = $memember_count + $memember_count_yes + $mercenary_count*2 ;
            //dd($memember_count,$memember_count_yes,$memember_point);
            // $publicer = \App\User::with('moneylogs')->where('email','admin')->first();
            // $public_money = $publicer->moneylogs->sum('amount');

            $customer = $user->customer;
            $killer_money = (int)($Castleimport->qty*$customer->kill_scale/100);
            $salary_money = (int)($Castleimport->qty*$customer->member_scale/100);
            $public_money_o = (int)($Castleimport->qty*$customer->public_scale/100);


            if($memember_point != 0){
                $memember_salary = (int)($salary_money/$memember_point);
            }else{
                $memember_salary = 0 ;
            }
            
            $killer_count = \App\models\Killer::where('date','>=',$start_day)
                                            ->where('date','<',$end_day)
                                            ->where('status',1)
                                            ->get()
                                            ->sum('qty');
            if($killer_count!=0){
                $killer_salary = (int)($killer_money/$killer_count);
            }else{
                $killer_salary = 0 ;
            }                  
            

           
            $lave =  $Castleimport->qty - $public_money_o - $memember_salary*$memember_point - $killer_count*$killer_salary;

            if($lave<0){
                return '剩餘金額<0  error 106';
            }

            $public_money = $public_money_o + $lave;
       



            $title = $start_day ." ~ ".$end_day.' ';



          
            $log = new \App\models\Salarylog;
            $log->start_day = $start_day;
            $log->end_day = $end_day;
            $log->castleimport = $original_Castleimport;

            $log->salary_money = $salary_money;
            $log->killer_money = $killer_money;
            $log->public_money = $public_money;
            $log->public_money_o = $public_money_o;

            $log->group_sup = 0;

            $log->memember_count = $memember_count;
            $log->memember_count_yes = $memember_count_yes;
            $log->mercenary_count = $mercenary_count;

            $log->memember_point = $memember_point;
            $log->memember_salary = $memember_salary;
            

            $log->killer_count = $killer_count;
            $log->killer_salary = $killer_salary;
            
        

            $log->status = 1;
            $log->user_id = $user->email;
            $log->save();


            if($killer_salary!=0){
                $p_killer = \App\models\Killer::selectRaw('user_id,sum(qty) as qty')
                                            ->where('date','>=',$start_day)
                                            ->where('date','<',$end_day)
                                            ->where('status',1)
                                            ->groupBy('user_id')
                                            ->get();
                foreach ($p_killer as $key => $value) {
                    $mlog = new \App\models\Moneylog;
                    $mlog ->source_type = $title.'補刀獎勵 補刀數*補刀比值 = ('.$value->qty.'*'.$killer_salary.')';
                    $mlog ->from_type = 2;
                    $mlog ->source_id = '';
                    $mlog ->amount = $value->qty*$killer_salary;
                    $mlog ->user_id = $value->user_id;
                    $mlog ->save();
                } 
            }
              


            if($question!=null){
                $p_user = \App\models\Question_answer::where('question_id',$question->id)->get();
                foreach ($p_user as $key => $value) {
                    $mlog = new \App\models\Moneylog;
                    $mlog ->source_id = '';
                    if($value->col1=='會'){
                        $mlog ->source_type = $title.'薪水獎金(填表['.$memember_salary.']+出席['.$memember_salary.'])';
                        $mlog ->amount = $memember_salary*2;
                    }
                    else{
                        $mlog ->source_type = $title.'薪水獎金(填表['.$memember_salary.'])';
                        $mlog ->amount = $memember_salary;
                    }
                    $mlog ->from_type = 3;
                    $mlog ->user_id = $value->user_id;
                    $mlog ->save();
                }
            }
           


            //加公積金
            $mlog = new \App\models\Moneylog;
            $mlog ->source_type = $title.'城鑽公積金(20%)';
            $mlog ->source_id = '';
            $mlog ->amount = $public_money;
            $mlog ->user_id = Auth::user()->customer_id.'_公積金';
            $mlog ->save();


            $update_clearDay =  \App\models\Clearingday::first();
            if($update_clearDay ==null){
                $update_clearDay = new \App\models\Clearingday;
            }
            $update_clearDay->day = $end_day;
            $update_clearDay->save();


            $this->CreateQuestion();



            DB::connection(Auth::user()->customer->dbname)->commit();
            
        } catch (Exception $e) {
            DB::connection(Auth::user()->customer->dbname)->rollBack();
            return $e;
            
        }
        
        return redirect('salary/index');
    }



    public function getCastleimport(){

        $user=Auth::user();
        if($user==null){
            return "error";
        }
        if (strpos($user->role_id, '5') === false) {
            return '無權限操作';
        }
        $start_day = \App\models\Castleimport::orderby('created_at','desc')->first();
        if($start_day==null){
            $start_day = date('Y-m-d', (time() - ((date('w') == 0 ? 7 : date('w')) - 5) * 24 * 3600));
        }else
        {
            $start_day = $start_day->day;
            $start_day = date('Y-m-d', strtotime($start_day . ' +7 day'));
        }

       
        return view('salary.castleimport',['start_day'=>$start_day]);
    }

    public function postCastleimport(Request $request){
        $user=Auth::user();
        if($user==null){
            return "error";
        }
        if (strpos($user->role_id, '5') === false) {
            return '無權限操作';
        }
        $data = $request->all();
       
        $start_day = \App\models\Castleimport::orderby('created_at','desc')->first();
        if($start_day==null){
            $start_day = date('Y-m-d', (time() - ((date('w') == 0 ? 7 : date('w')) - 5) * 24 * 3600));
        }else
        {
            $start_day = $start_day->day;
            $start_day = date('Y-m-d', strtotime($start_day . ' +7 day'));
        }

        $n_castle = new \App\models\Castleimport;
        $n_castle->day = $start_day;
        $n_castle->qty = $data['_qty'];
        $n_castle->mercenary = $data['_mercenary'];
        $n_castle->name = "城鑽收入";
        $n_castle->save();

       
        return back();
    }

    public function CreateQuestion(){
        // '7', '1', '本週(07/15)攻城戰是否參加?????', '2018-07-08 00:00:00', '2018-07-15 18:00:00'
        $last_question = \App\models\Question::where('type',1)
                                            ->orderby('id','desc')
                                            ->first();
        if($last_question!=null){
            $start_day = $last_question->end_day;
        }
        $new_start_day =  date('Y-m-d', strtotime($start_day))." 00:00:00";
        $new_title =  date('Y-m-d', strtotime($start_day . ' +7 day'));
        $new_end_day = $new_title." 18:00:00";
       
        $new_question = new \App\models\Question;
        $new_question->type = 1;
        $new_question->title = '本週('.$new_title.')攻城戰是否參加?????';
        $new_question->start_day = $new_start_day;
        $new_question->end_day=$new_end_day;
        $new_question->save();




        $new_a = new \App\models\Question_detail;
        $new_a->question_id = $new_question->id;
        $new_a->sort = 1;
        $new_a->title = '是否有時間參加?';
        $new_a->code_type="S";
        $new_a->option=["會","不會"];
        $new_a->save();


        $guild_list = \App\models\Guild::all()->pluck('name')->toArray();
//        $g  = implode('","', $guild_list);

        $new_b = new \App\models\Question_detail;
        $new_b->question_id = $new_question->id;
        $new_b->sort = 2;
        $new_b->title = '請選擇攻城時參加的血盟?';
        $new_b->code_type="S";
        $new_b->option=$guild_list;
        $new_b->save();

        $job_list = \App\models\Job::all()->pluck('name')->toArray();
      //  $j  = implode('","', $job_list);
        $new_c = new \App\models\Question_detail;
        $new_c->question_id = $new_question->id;
        $new_c->sort = 3;
        $new_c->title = '職業?';
        $new_c->code_type="S";
        $new_c->option=$job_list;
        $new_c->save();


    }

 	

 
}