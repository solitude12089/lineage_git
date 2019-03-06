<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;


class QuestionController extends Controller
{


    protected $special =['波雅漢考克','Ktin','歐巴馬','莫心','賴青德','郝神奇','摸奶王','米酒頭','參貳之壹柒','參貳之廷','冰女神','洵','釣鴨妹','屎蓋葛格','妳韓爺爺棒棒','無敵喵喵熊','寒羽柔','狂歡'];
    protected $special_admin = ['郝神奇','徐國勇','賴青德'];





	public function getIndex()
    {
        $user = Auth::user();
        $date = date('Y-m-d');
        $special = $this->special;

        if($user->role_id==4){
            $question = \App\models\Question::all();
        }
        else{
            $question = \App\models\Question::where('end_day','>=',$date)
                    ->get();
        }
       
                 
        foreach ($question as $key => $value) {
            $qa = \App\models\Question_answer::where('question_id',$value->id)
                                            ->where('user_id',$user->email)
                                            ->first();
            $value->have_answer = null;
            if($qa!=null){
                $value->have_answer=$qa->id;
            }                                
        }
        return view('question.index',compact('question','date','special'));
    }

    public function getAnswer($question_id)
    {
        $question = \App\models\Question::with('details')
                                        ->where('id',$question_id)
                                        ->first();
        return view('question.answer',compact('question'));
    }

    public function postAnswer(Request $request,$question_id)
    {   
        $data = $request->all();
        //dd($data);
        $user = Auth::user();
        $fw = new \App\Http\Controllers\FileserverController;
        $question_detail_map = \App\models\Question_detail::where('question_id',$question_id)
                                                    ->get()
                                                    ->pluck('code_type','sort')
                                                    ->toArray();


        $old = \App\models\Question_answer::where('question_id',$question_id)
                                        ->where('user_id',$user->email)
                                        ->first();

        if($old!=null){
            return '已填寫過再問卷,無法再填寫';
        }    





      
        $qa =  new \App\models\Question_answer;
        $qa->question_id = $question_id;
        $qa->user_id = $user->email;
        $qa->save();

        foreach ($data as $key => $value) {
            $index = substr($key,3,strlen($key)-1);
            if($question_detail_map[$index]=='F'){
                if($request->file($key)!=null)
                {
                    $f =  $request->file($key);
                    $fw->upload($value,$qa->id,'question');

                }
            }
            if($question_detail_map[$index]=='M'){
                $data[$key] = implode(",",$value);
            }
        }

      
        $qa->update($data);
        return redirect('question/index');
    }


    public function getAnswerEdit($question_id,$answer_id)
    {
        $question = \App\models\Question::with('details')
                                        ->where('id',$question_id)
                                        ->first();
        $qa = \App\models\Question_answer::where('id',$answer_id)
                                        ->first();
        $question_detail_map = \App\models\Question_detail::where('question_id',$question_id)
                                                    ->get()
                                                    ->pluck('code_type','sort')
                                                    ->toArray();
        return view('question.answer_edit',compact('question','qa','question_detail_map'));
    }

    public function postAnswerEdit(Request $request,$question_id,$answer_id)
    {

        $data = $request->all();
        //dd($data);
        $user = Auth::user();
        $fw = new \App\Http\Controllers\FileserverController;
        $question_detail_map = \App\models\Question_detail::where('question_id',$question_id)
                                                    ->get()
                                                    ->pluck('code_type','sort')
                                                    ->toArray();
      
        $qa =  \App\models\Question_answer::where('id',$answer_id)->first();
        foreach ($data as $key => $value) {
            $index = substr($key,3,strlen($key)-1);
            if($question_detail_map[$index]=='F'){
                if($request->file($key)!=null)
                {
                    $f =  $request->file($key);
                    $fw->upload($value,$qa->id,'question');

                }
            }
            if($question_detail_map[$index]=='M'){
                $data[$key] = implode(",",$value);
            }
        }

      
        $qa->update($data);
        return redirect('question/index');
    }

    public function getResults($question_id){
        $user = Auth::user();
        if (strpos($user->role_id, '3')===false) {
            return '無權限操作';
        }
        $question = \App\models\Question::with('details')
                                        ->where('id',$question_id)
                                        ->first();


        // if($question->type==2){
        //     if(in_array(Auth::user()->name,$this->special)||Auth::user()->name=='徐國勇'){
        //     }
        //     else{
        //         return view('layouts.msg',['msg' => '權限不足']);
        //     }
        // }
        $qas =  \App\models\Question_answer::where('question_id',$question_id)->get();
        // if($question->type==2){
        //     if(in_array(Auth::user()->email,$this->special_admin)){

        //     }
        //     else{
        //         $qas = \App\models\Question_answer::where('question_id',$question_id)
        //                                         ->where('col3',Auth::user()->guild)
        //                                         ->get();

        //     }


            
        //     foreach ($qas as $key => $value) {
        //         $all_get = \App\models\Moneylog::where('user_id',$value->user_id)
        //                                         ->where('amount','>',0)
        //                                         ->sum('amount');
        //         $value->all_get = $all_get;
        //     }
        // }
       
        //dd($question,$qas);

        $question_detail_map = \App\models\Question_detail::where('question_id',$question_id)
                                                    ->get()
                                                    ->pluck('code_type','sort')
                                                    ->toArray();


        return view('question.results',compact('question','qas','question_detail_map'));
    }

    public function getReport($question_id){
        $question = \App\models\Question::with('details')
                                        ->where('id',$question_id)
                                        ->first();
        $qas =  \App\models\Question_answer::where('question_id',$question_id)->get();

        $qas_all = $qas->count();
        $qas_yes =  \App\models\Question_answer::where('question_id',$question_id)
                                                ->where('col1','會')
                                                ->count();
        $qas_not = $qas_all - $qas_yes;


        $rt_data = [];
        foreach ($qas as $key => $value) {
            if($value->col1=="會"){
                $rt_data[$value->col2][$value->col3][]=$value->id;
            }
            else{
                $rt_data[$value->col2]['不會到'][]=$value->id;
            }
            # code...
        }
      
        return view('question.report_two',compact('question','qas','rt_data','qas_all','qas_yes','qas_not'));
    }

    public function getReview($question_id){
        $question = \App\models\Question::with('details')
                                        ->where('id',$question_id)
                                        ->first();
        $qas =  \App\models\Question_answer::where('question_id',$question_id)
                                            ->where('status',1)
                                            ->get();
        $guilds = \App\models\Guild::all();
        return view('question.review',compact('question','qas','guilds'));
    }


    public function postReview(Request $request){
        $user = Auth::user();
        $data = $request->all();
        $qa =  \App\models\Question_answer::where('id',$data['id'])
                                        ->first();
        if($qa){
            $qa->review_user=$user->email;
            $qa->col1=$data['col1'];
            $qa->status = 2;
            $qa->save();
        }
    }



    public function getPic($answer_id){
        $attachment = \App\models\attachment::where('type','question')
                                    ->where('target_id',$answer_id)
                                    ->first();
        return view('question.pic',['attachment'=>$attachment]);
    }

   
}