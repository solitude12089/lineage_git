<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Log;


class ReportController extends Controller
{
	public function getIndex()
    {

    	$data = DB::connection(Auth::user()->customer->dbname)->select('SELECT day,IFNULL(sum(really_price),0) as t_qty,0 as c_qty 
																		FROM treasure
																		group by day
																		union
																		SELECT day,0 as t_qty,qty as c_qty 
																		FROM castle_import');
    	
        return view('report.index',compact('data'));
    }
}