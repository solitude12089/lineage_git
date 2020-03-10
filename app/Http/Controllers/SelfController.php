<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Log;
use Crypt;
use Hash;

class SelfController extends Controller
{

	public function getTest()
	{
		  // $access_token = 'w46zv1AA5OInQkHfpdeEmsiFxZZoHB7Dnu4IzqdafvNlR8YkcAj5NEEpUEdCAhkOEnJMLa7TPpqAjlrj2FIK8wpAmTULdlx4j+6/6iFV2pGu7jptjml0dx+MLAUIAG0byKAXZCaXct58t2CLSSEb+wdB04t89/1O/w1cDnyilFU=';
    //         $secret = '42b890d42af676ea08830dd8cb9660d3';

    //         $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
    //         $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $secret]);
    //         $msg='AAAABBB';
    //         $content = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($msg);
    //         // $piccontent = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder('https://uhs.umich.edu/files/uhs/field/image/TEST.jpg', 'https://uhs.umich.edu/files/uhs/field/image/TEST.jpg');
    //         // //$bot->pushMessage('C470c5b833685d6202256900acdf01998', $piccontent);
    //         // $actions = array(
    //         //   //一般訊息型 action
    //         //   new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder("按鈕1","文字1"),
    //         //   //網址型 action
    //         //   new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("Google","http://www.google.com"),
    //         //   //下列兩筆均為互動型action
    //         //   new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("下一頁", "page=3"),
    //         //   new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("上一頁", "page=1")
    //         // );
             
    //         // $img_url = "https://cdn.pixabay.com/photo/2014/06/03/19/38/road-sign-361514_960_720.png";
    //         // $button = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder("按鈕文字","說明", $img_url, $actions);
    //         // $msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要用手機的賴才看的到哦", $button);

    //         // for ($x = 0; $x <= 10; $x++) {
    //            $bot->pushMessage('Cdbc664f07f4c7e9b332647843617e761', $content);
            // } 
            

          $linetools = new \App\Http\Controllers\Tools\DiscordTools;
        $linetools->push('AA');

	}


	public function getIndex()
    {
    	$user=Auth::user();
    	$moneylogs = \App\models\Moneylog::with('treasure')
    									->where('user_id',$user->email)
    									->orderBy('created_at','desc')
    									->get();
        $user_list = \App\User::where('customer_id',Auth::user()->customer_id)->where('status',1)->get()->pluck('name','email')->toArray();
    	
    	return view('self.index',['moneylogs'=>$moneylogs,'user_list'=>$user_list]);
    }



                            
    public function getInfo($moneylog_id)
    {
    	
    	$user=Auth::user();
        $customer = $user->customer;
    	$boss_list = \App\models\Boss::all()->pluck('name','id');
    	$moneylog = \App\models\Moneylog::with('treasure')
    									->with('treasure.owner_name')
		    							->with('treasure.details')
		    							->with('treasure.details.user')
		    							->with('treasure.attachments')
		    							->where('id',$moneylog_id)
		    							->first();
    	
    	return view('self.info',['moneylog'=>$moneylog,'boss_list'=>$boss_list,'customer'=>$customer]);
    }

   

    
 	
 	public function postDoimport(Request $request,$treasure_id){
        dd("看到此畫面請聯絡管理員");
        $user = Auth::user();
 		$data = $request->all();
 		$treasure = \App\models\Treasure::with('user')
 									->with('details')
 									->where('id',$treasure_id)
 									->first();
 		if($treasure->status!=1)
 		{
 			return "此單號已經入帳 , 入帳失敗";
 		}
 		$public_money =  (int)($data['really_price']*0.2);
		$avg = (int)($data['really_price']*0.8/count($treasure->details));

 		$treasure->really_price = $data['really_price'];
 		$treasure->status=2;
 		$treasure->save();
 		Log::info("Treasure_id : ".$treasure->id.' 入帳 '.$data['really_price'].' by '.$user->name);
 	
 		foreach ($treasure->details as $key => $value) {
 			$mlog = new \App\models\Moneylog;
 			$mlog ->source_type = 'treasure';
 			$mlog ->source_id = $treasure->id;
 			$mlog ->amount = $avg;
 			$mlog ->user_id = $value->user_id;
 			$mlog ->save();
 		}
 		$mlog = new \App\models\Moneylog;
		$mlog ->source_type = 'treasure';
		$mlog ->source_id = $treasure->id;
		$mlog ->amount = $public_money;
		$mlog ->user_id = 'admin';
		$mlog ->save();


 		return redirect('import/index');
 	}

}