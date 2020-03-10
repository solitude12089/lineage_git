<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
class DepositController extends Controller
{
    
    public function getIndex()
    {
        $user = Auth::user();

     

        $deposits = \App\models\Deposit::all();


        return view('deposit.index',['user'=>$user,'deposits'=>$deposits]);
    }

    public function getAdd()
    {
        $user=Auth::user();
        if($user==null){
            return "error";
        }

        if (strpos($user->role_id, '6') === false) {
            return '權限不足';
        }

        $user_list = \App\User::where('customer_id',Auth::user()->customer_id)->where('status',1)->get();
    
        foreach ($user_list as $key => $value) {
            $bygroup[$value->guild][]=$value;
        }

        return view('deposit.add',['user_list'=>$user_list,'bygroup'=>$bygroup]);
    }

    public function postAdd(Request $request){
        $user=Auth::user();
        if($user==null){
            return "error";
        }
        if (strpos($user->role_id, '6') === false) {
            return '權限不足';
        }
        $data = $request->all();
        $date = date('Ymd');
        $first_note= \App\models\Deposit::where('no','like',"D".$date.'%')
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

        $new_deposit=new \App\models\Deposit;
        $new_deposit->no="D".$_no;
        $new_deposit->date=$date;
        $new_deposit->qty=$data['_qty'];
        $new_deposit->owner=$data['_owner'];
        $new_deposit->user_id=$user->email;
        $new_deposit->save();

        $mlog = new \App\models\Moneylog;
        $mlog ->source_type = 'deposit';
        $mlog ->from_type = 0;
        $mlog ->source_id = $new_deposit->id;
        $mlog ->amount = $data['_qty'];
        $mlog ->user_id =$data['_owner'];
        $mlog ->save();
        
        return back();
    }
    public function postDelete(Request $request,$deposit_id){
        if($user==null){
            return "error";
        }
        if (strpos($user->role_id, '6') === false) {
            return '權限不足';
        }
        $data = $request->all();

        $deposit =  \App\models\Deposit::where('id','=',$deposit_id)->first();
        if($deposit==null){
            return "刪除失敗";
        }

        $mlog = \App\models\Moneylog::where('source_type','=','deposit')
                                    ->where('source_id','=',$deposit->id)
                                    ->first();
        if($mlog==null){
            return "刪除失敗";
        }

        $deposit->delete();
        $mlog->delete();
        return back();
    }



   
}
