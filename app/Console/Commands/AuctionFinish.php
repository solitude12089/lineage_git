<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Auth;

class AuctionFinish extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:auction-finish';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command AuctionFinish';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		// $user = \App\User::where('id',2)->first();
		$user_s = \App\User::where('name','管理員')->get();

		foreach ($user_s as $uk => $user) {
			Auth::login($user);
			$now = date('Y-m-d');
			$auction = \App\models\Auction::where('status',0)
									->get();

			foreach ($auction as $key => $value) {
				# code...
				if($value->end_day < $now){

					$max_detail = \App\models\Auction_detail::where('auction_id',$value->id)
													->orderBy('price','desc')
													->first();
					if($max_detail!=null){
						$second_detail = \App\models\Auction_detail::where('auction_id',$value->id)
													->where('id','!=',$max_detail->id)
													->orderBy('price','desc')
													->first();
						if($second_detail!=null){
							$unit = round($value->min_price/100,0)<1?1:round($value->min_price/100,0);
							$get_price = $second_detail->price+$unit;
							if($get_price>$max_detail->price){
								$value->now_price = $max_detail->price;
							}
							else{
								$value->now_price = $get_price;
							}
							
							$value->now_owner = $max_detail->user_id;
						}
						else{
							$value->now_price = $max_detail->price;
							$value->now_owner = $max_detail->user_id;
						}

					   
					}
					$value->status = 2;
					$value->save();

					if($max_detail != null){
						$su_user = \App\User::where('email',$max_detail->user_id)->first();
						$customer = \App\models\customer::where('id',$user->customer_id)
												->first();

						// $access_token = '8L7+iU4Wj9pn+0/+Qii7IoMNT7JhHK450WGwnBSNyc+0ndKH3++M9kkqHUtiqQQra8/OTguNeI2o+C8bJ7/lY+0H+pUHp1LFl6mLUVREFvmahvFdi0k5CIN12mZVkDXOxuIBF1whwoamYmg+ILOe/wdB04t89/1O/w1cDnyilFU=';
						// $secret = '47a50c9a7742bc5dacfcc5b166316e91';

						// $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
						// $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $secret]);
						$msg=$su_user->name." 於拍賣場  成功得標了 商品 ".$value->no." 
			寶物名稱：".$value->name."
			截標時間：".$value->end_day." 23:59:59
			得標價格：".$value->now_price."
			http://www.lineagebank.tw/auction/infohistory/".$value->id;
						$linetools = new \App\Http\Controllers\Tools\LineTools;
            			$linetools->push($msg);
						// $content = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($msg);
						// $bot->pushMessage($customer->line_id, $content);
					}
				}
			}
		}



	}
}
