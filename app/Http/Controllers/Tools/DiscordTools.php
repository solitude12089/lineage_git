<?php 
namespace App\Http\Controllers\Tools;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;

class DiscordTools {

	public function push($msg){
		$url = 'https://discordapp.com/api/webhooks/592657083464417285/gAWDkFnK6wLcYxksdBi8wFUbDCIMEl3VYEZaLsvOnAvAYjb7orQPYWlGL9Z47Fgp8fPG';
        $data = [
            'username' => '銀行Bot',
            'content' => '測試測試',
        ];

		$ch = curl_init($url);
		
		curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		curl_setopt($ch, CURLOPT_HTTPHEADER,array(
                        'Content-type: application/json'
                        )); 
		$rtn = curl_exec($ch);//CURLOPT_RETURNTRANSFER 不设置  curl_exec返回TRUE 设置  curl_exec返回json(此处) 失败都返回FALSE
		curl_close($ch);




        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, );
        // $response = curl_exec($ch);
        // curl_close($ch);
        // $rs = json_decode($response);
		       
	}
}



?>