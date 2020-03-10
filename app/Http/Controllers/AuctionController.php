<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;


class AuctionController extends Controller
{
	public function getIndex()
    {
    	$user=Auth::user();
    
        $now = date('Y-m-d');
    	$auction_list = \App\models\Auction::where('end_day','>=',$now)->get();
        $history_auction = \App\models\Auction::where('end_day','<',$now)->get();


        $user_map = \App\User::where('customer_id',Auth::user()->customer_id)
         ->where('status','!=',2)
         ->get()
         ->pluck('name','email')->toArray();
       
    	return view('auction.index',['auction_list'=>$auction_list,'user_map'=>$user_map,'history_auction'=>$history_auction]);
    }





                            
    public function getInfo($auction_id)
    {
    	
    	$user=Auth::user();
    	$now = date('Y-m-d');
    	$auction = \App\models\Auction::where('id',$auction_id)
    							->first();
        if(!$auction){
            return view('layouts.msg',['msg'=>'找不到競標商品']);
        }
        if($auction->end_day<$now){
             return view('layouts.msg',['msg'=>'商品已經截標']);
        }
        $user_map = \App\User::where('customer_id',Auth::user()->customer_id)
         ->where('status','!=',2)
         ->get()
         ->pluck('name','email')->toArray();
        $auction_detail = \App\models\Auction_detail::where('auction_id',$auction_id)
                                                    ->where('user_id',$user->email)
                                                    ->first();
      

        $unit = round($auction->min_price/100,0)<1?1:round($auction->min_price/100,0);

    	return view('auction.info',['user'=>$user,'auction'=>$auction,'user_map'=>$user_map,'unit'=>$unit,'auction_detail'=>$auction_detail]);
    }
    public function getInfohistory($auction_id)
    {
        
        $user=Auth::user();
        $now = date('Y-m-d');
        // $auction = \App\models\Auction::with('details')
        //                         ->where('id',$auction_id)
        //                         ->first();
        $auction = \App\models\Auction::where('id',$auction_id)
                                ->first();

        if(!$auction){
            return view('layouts.msg',['msg'=>'找不到競標商品']);
        }
        if($auction->end_day>=$now){
             return view('layouts.msg',['msg'=>'商品還在競標中']);
        }
        $user_map = \App\User::where('customer_id',Auth::user()->customer_id)
         ->where('status','!=',2)
         ->get()
         ->pluck('name','email')->toArray();

        



        return view('auction.infohistory',['user'=>$user,'auction'=>$auction,'user_map'=>$user_map]);
    }

    public function postOffer(Request $request,$auction_id)
    {
    	$user=Auth::user();
        $successful = false;
        $data=$request->all();
        $auction = \App\models\Auction::with('details')
                                ->where('id',$auction_id)
                                ->first();

        $auction_detail = \App\models\Auction_detail::where('auction_id',$auction_id)
                                                    ->where('user_id',$user->email)
                                                    ->first();

        if($auction_detail==null){
            $dtl=new \App\models\Auction_detail;
            $dtl->auction_id=$auction->id;
            $dtl->user_id=$user->email;
            $dtl->price=$data['post_price'];
            $dtl->save();
        }
        else{
            $auction_detail ->price=$data['post_price'];
            $auction_detail->save();
        }

        // $max_offer = \App\models\Auction_detail::where('auction_id',$auction_id)
        //                                         ->orderBy('price','desc')
        //                                         ->first();

        // $dtl=new \App\models\Auction_detail;
        //             $dtl->auction_id=$auction->id;
        //             $dtl->user_id=$user->email;
        //             $dtl->price=$data['post_price'];
        //             $dtl->save();
        // $unit = round($auction->min_price/100,0)<1?1:round($auction->min_price/100,0);

        // if($max_offer == null){
        //     $successful = true;
        //     $auction->now_price = $auction->min_price + $unit;
        //     $auction->now_owner = $user->email;
        // }
        // else{
        //     if($data['post_price']>$max_offer->price){
        //         $successful = true;
        //         $auction->now_price = $max_offer->price + $unit;
        //         $auction->now_owner = $user->email;
        //     }
        //     else{
        //         if($data['post_price']==$max_offer->price){
        //             $auction->now_price = $data['post_price'];
        //         }
        //         else{
        //             $auction->now_price = $data['post_price'] + $unit;
        //         }
                
        //     }
        // }
        // $auction->save();






//         $access_token = '8L7+iU4Wj9pn+0/+Qii7IoMNT7JhHK450WGwnBSNyc+0ndKH3++M9kkqHUtiqQQra8/OTguNeI2o+C8bJ7/lY+0H+pUHp1LFl6mLUVREFvmahvFdi0k5CIN12mZVkDXOxuIBF1whwoamYmg+ILOe/wdB04t89/1O/w1cDnyilFU=';
//         $secret = '47a50c9a7742bc5dacfcc5b166316e91';

//             $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
//             $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $secret]);
//             $msg=$user->email." 於競標了 拍賣商品 ".$auction->no." 
// 寶物名稱：".$auction->name."
// 出價金額：".$dtl->price."
// http://www.lineagebank.tw/auction/info/".$auction->id;
//             $content = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($msg);
// //            $bot->pushMessage('C6b03d9f527e90b9977a92293aa0ec9ce', $content);
// if($successful){
           

          
            $msg=$user->name." 於拍賣場  成功競標了 商品 ".$auction->no." 
寶物名稱：".$auction->name."
截標時間".$auction->end_day." 23:59:59
http://www.lineagebank.tw/auction/info/".$auction->id;



            $linetools = new \App\Http\Controllers\Tools\LineTools;
            $linetools->push($msg);

// }
            
          



    	return back();
    }

     public function postDeleteOffer($auction_id){

        $user=Auth::user();
        if($user==null){
            return "error";
        }
        $auction = \App\models\Auction::where('id',$auction_id)->first();
        $auction_detail = \App\models\Auction_detail::where('auction_id',$auction_id)
                                ->where('user_id',$user->email)
                                ->first();
        if($auction_detail==null){
            return view('layouts.msg',['msg' => '棄標失敗,找不到該競標紀錄']);
        }
        else{
            $auction_detail->delete();
            // $customer = \App\models\customer::where('id',$user->customer_id)
            //                                 ->first();
            // $access_token = '8L7+iU4Wj9pn+0/+Qii7IoMNT7JhHK450WGwnBSNyc+0ndKH3++M9kkqHUtiqQQra8/OTguNeI2o+C8bJ7/lY+0H+pUHp1LFl6mLUVREFvmahvFdi0k5CIN12mZVkDXOxuIBF1whwoamYmg+ILOe/wdB04t89/1O/w1cDnyilFU=';
            // $secret = '47a50c9a7742bc5dacfcc5b166316e91';

            // $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
            // $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $secret]);
            $msg=$user->name." 於拍賣場  棄標了 商品 ".$auction->no." 
寶物名稱：".$auction->name;
            // $content = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($msg);
            // $bot->pushMessage($customer->line_id, $content);

            $linetools = new \App\Http\Controllers\Tools\LineTools;
            $linetools->push($msg);

            
            return back();
        }
    }


    public function getAdd()
    {
        $user=Auth::user();
        if($user==null){
            return "error";
        }

        return view('auction.add');
    }

    






 	public function postAdd(Request $request)
    {


    	$user=Auth::user();
       
    	if($user==null){
    		return "error";
    	}

    	
        $date = date('Ymd');
        $data=$request->all();

        $first_note= \App\models\Auction::where('no','like',"A".$date.'%')
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
     

        $new_note=new \App\models\Auction;
        $new_note->no="A".$_no;
        $new_note->name=$data['name'];
        $new_note->qty=$data['qty'];
        $new_note->min_price=$data['min_price'];
        $new_note->end_day = $data['end_day'];
     
        $new_note->user_id=$user->email;
        $new_note->save();


            // $access_token = 'w46zv1AA5OInQkHfpdeEmsiFxZZoHB7Dnu4IzqdafvNlR8YkcAj5NEEpUEdCAhkOEnJMLa7TPpqAjlrj2FIK8wpAmTULdlx4j+6/6iFV2pGu7jptjml0dx+MLAUIAG0byKAXZCaXct58t2CLSSEb+wdB04t89/1O/w1cDnyilFU=';
            // $secret = '42b890d42af676ea08830dd8cb9660d3';

            // $customer = \App\models\customer::where('id',$user->customer_id)
            //                             ->first();

            // $access_token = '8L7+iU4Wj9pn+0/+Qii7IoMNT7JhHK450WGwnBSNyc+0ndKH3++M9kkqHUtiqQQra8/OTguNeI2o+C8bJ7/lY+0H+pUHp1LFl6mLUVREFvmahvFdi0k5CIN12mZVkDXOxuIBF1whwoamYmg+ILOe/wdB04t89/1O/w1cDnyilFU=';
            // $secret = '47a50c9a7742bc5dacfcc5b166316e91';

            // $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
            // $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $secret]);
            $msg=$user->name." 於拍賣場 建立了 新商品 ".$new_note->no." 
寶物名稱：".$new_note->name."
起標價格".$new_note->min_price."
截標時間".$new_note->end_day." 23:59:59
http://www.lineagebank.tw/auction/info/".$new_note->id;
            // $content = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($msg);
            // $bot->pushMessage($customer->line_id, $content);

            $linetools = new \App\Http\Controllers\Tools\LineTools;
            $linetools->push($msg);

      

       
        return back();
    }


 	

  







}