<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getChangePassword()
    {
        $user=Auth::user();
        if($user==null){
            return "error";
        }
        return view('user.changepassword');
    }

    public function postChangePassword(Request $request)
    {
        $user=Auth::user();
        if($user==null){
            return "error";
        }
        $data=$request->all();

        $c_user = \App\User::where('id',$user->id)->first();
        $c_user->password = bcrypt($data['password']);
        $c_user->save();
        return view('user.changeSuccess');
    }
    public function getCreateUser(){
        $user=Auth::user();
        $guild = \App\models\Guild::all();

        if (strpos($user->role_id, '3')===false) {
            return '無權限操作';
        }
        $jobs = \App\models\Job::all();

      
        
        return view('user.createUser',['guild'=>$guild,'jobs'=>$jobs]);
    }
    public function postCreateUser(Request $request){
        $user=Auth::user();
        if($user==null){
            return "error";
        }


        $data=$request->all();

        if(!isset($data['user'])||$data['user']==""){
            return "error 請輸入帳號";
        }

        $old_user = \App\User::where('customer_id',Auth::user()->customer_id)->where('name',$data['user'])->first();
        if($old_user!=null){
            return "error 重複創角";
        }

        $c_user = new \App\User;
        $c_user->customer_id = $user->customer_id;
        $c_user->name = $data['user'];
        $c_user->email = $user->customer_id."_".$data['user'];
        $c_user->password = bcrypt('1234');
        $c_user->job = $data['job'];
        $c_user->guild = $data['guild'];
        $c_user->status = 1;
        $c_user->save();
        return view('user.createSuccess');
    }




    public function getTest(){
        return view('user.test');
    }
}
