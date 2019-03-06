<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;


class KillerController extends Controller
{
	public function getIndex()
    {
        $user = Auth::user();
        $start_day = \App\models\Clearingday::first();
        if($start_day==null){
            $start_day = date('Y-m-d');
        }else
        {
            $start_day = $start_day->day;
        }

       
        $end_day = date('Y-m-d', strtotime($start_day . ' +6 day'));
    	
        $filter_day = date('Y-m-d', strtotime($start_day . ' -6 day'));

    	$killers = \App\models\Killer::with('user')
                                    ->with('attachments')
                                    ->orderBy('created_at','desc')
                                    ->where('status',1)
                                    ->where('created_at','>=',$filter_day)
                                    ->get();
    	//dd($killers);
    	return view('killer.index',['user'=>$user,'killers'=>$killers,'start_day'=>$start_day,'end_day'=>$end_day]);
    }

    public function getAdd()
    {
    	$user=Auth::user();
    	if($user==null){
    		return "error";
    	}
    	return view('killer.add');
    }
 	public function postAdd(Request $request)
    {
    	$user=Auth::user();
    	if($user==null){
    		return "error";
    	}

    	$fw = new \App\Http\Controllers\FileserverController;
        $date = date('Ymd');
        $data=$request->all();
        
        $first_note= \App\models\Killer::where('no','like',"K".$date.'%')
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

        $new_note=new \App\models\Killer;
        $new_note->no="K".$_no;
        $new_note->date=$data['_date'];
        $new_note->qty=$data['_qty'];
        $new_note->user_id=$user->email;
        $new_note->note=$data['_note'];
        $new_note->save();
        //file
        if($request->file('_file')!=null)
        {
            foreach ($request->file('_file') as $key => $value) {
                if($value)
                {
                    $fw->upload($value,$new_note->id,'killer');
                }
            }
        }
        
       
        return back();
    }

    public function postDelete($killer_id){
        $user = Auth::user();
        $killers = \App\models\Killer::where('id',$killer_id)
                                    ->first();
        $killers->status = 9;
        $killers->delete_by = $user->email;
        $killers->save();

        return redirect(url('killer/index'));
    }

 	public function getPic($killer_id){
 		$killer = \App\models\Killer::with('user')
 									->with('attachments')
 									->where('id',$killer_id)
 									->first();
 									
 		return view('killer.pic',['killer'=>$killer]);
 	}
}