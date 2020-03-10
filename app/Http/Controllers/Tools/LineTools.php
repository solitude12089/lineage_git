<?php 
namespace App\Http\Controllers\Tools;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;

class LineTools {
	public function push($msg){
		try {
			$user=Auth::user();
            $customer = \App\models\customer::where('id',$user->customer_id)
                                        ->first();
            //Line
            if($customer->notification_mode ==1){
        	  	$access_token = $customer->access_token;
	            $secret = $customer->secret;
	            $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
	            $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $secret]);
	            $content = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($msg);
	            $res  = $bot->pushMessage($customer->line_id, $content);
            }
            else{
            	$url = $customer->discord_url;//'https://discordapp.com/api/webhooks/592657083464417285/gAWDkFnK6wLcYxksdBi8wFUbDCIMEl3VYEZaLsvOnAvAYjb7orQPYWlGL9Z47Fgp8fPG';
		        $data = [
		            'username' => '銀行Bot',
		            'content' => $msg,
		        ];

				$ch = curl_init($url);
				
				curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
				curl_setopt($ch, CURLOPT_POST, TRUE);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
				curl_setopt($ch, CURLOPT_HTTPHEADER,array(
		                        'Content-type: application/json'
		                        )); 
				$rtn = curl_exec($ch);
				curl_close($ch);
            }

          
			// \Log::debug(__FUNCTION__.' LineTool Status: '.$res->getHTTPStatus());
		} catch (\Exception $e) {
			\Log::debug(__FUNCTION__.' Exception : '.$e->getMessage());
		
		}
		
	}
}



?>