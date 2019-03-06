<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;


class RoleController extends Controller
{
	public function getAuthorityView()
    {
        $user = Auth::user();
        if (strpos($user->role_id, '3') === false) {
            return '權限不足';
        }
        if (strpos($user->role_id, '5') === false) {
           $user_list = \App\User::where('customer_id',Auth::user()->customer_id)
                            ->where('guild',$user->guild)
                            ->where('status','!=',2)
                            ->get();
        }
        else{
           $user_list = \App\User::where('customer_id',Auth::user()->customer_id)
                            ->where('status','!=',2)
                            ->get();
        }
        
        $role_list = \App\models\Role::all()->pluck('name','id');

        return view('role.authorityview',['user_list'=>$user_list,'role_list'=>$role_list]);
    }
    public function postResetpwd(Request $request)
    {
        $data = $request->all();
        $user =  \App\User::where('customer_id',Auth::user()->customer_id)->where('id',$data['id'])->first();
        $user->password='$2y$10$BWrRq3rDBSQluE8uwD1kteni6A2J2BWSmqf2JQOzoEvzIkYQLvlJ.';
        $user->save();
    }
    public function postChangeAuthority(Request $request)
    {
        $data = $request->all();
        if(!isset($data['authority'])){
            $data['authority'] = [1];
        }
        $user =  \App\User::where('customer_id',Auth::user()->customer_id)->where('id',$data['id'])->first();
        $user->role_id=implode(",",$data['authority']);;
        $user->save();
    }

    public function postChangeStatus(Request $request)
    {
        $data = $request->all();

        $user =  \App\User::where('customer_id',Auth::user()->customer_id)->where('id',$data['id'])->first();
        $user->status=$data['status'];
        $user->save();
    }
}