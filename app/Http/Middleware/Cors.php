<?php

namespace App\Http\Middleware;

use Closure;
use Log;
class Cors
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$whitelist = array(
			'127.0.0.1',
			'::1'
		);
		if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
			if($request->header('Authorization')!=null){
				
				$base64 = str_replace('Basic ','',$request->header('Authorization'));
	            $unbase64 = base64_decode($base64);
	            $exp = explode(':', $unbase64);
	            if(count($exp)!=2){
	            	return response()->json(array('result' => false, 'message' => 'Authorization error.'), 500);
	            }
	            $app_id = $exp[0];
	            $app_key = $exp[1];

	            if($app_id!='apple'&&$app_key!='1234'){
					return response()->json(array('result' => false, 'message' => 'Authorization error.'), 500);
				}
			}
			else{
				return response()->json(array('result' => false, 'message' => 'Miss Authorization.'), 500);
			}
		}
	  
		$response = $next($request);

		$response->headers->set('Access-Control-Allow-Origin' , '*');
		$response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
		$response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');

		return $response;
	}
}
