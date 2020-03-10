<?php 
namespace App\Http\Controllers\Api\v1;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class LineController extends Controller {
	public function getTest(){
		
		return 'AA';
	}
	public function postTest(Request $request){
		$rt_data = $request->all(); 

		if(isset($rt_data->postData)){
			\Log::debug(__FUNCTION__.' ZZZZ'.$rt_data->postData->contents->events);
		}
		\Log::debug(__FUNCTION__.' Response : '.json_encode($rt_data));
		return 'AA';
	}



}




?>
