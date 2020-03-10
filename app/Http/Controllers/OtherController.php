<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Log;



class OtherController extends Controller
{
	public function getIndex()
    {
        dd('AA');
        $book = \App\models\bookTable::with('relatives')
                                ->where('id',42)
                                ->first();
        dd($book);
    }

    public function getBook(){
        $books = \App\models\bookTable::all();
        foreach ($books as $key => $book) {
            $b_table[$book->level][]=$book;
        }
        //dd($b_table);
        return View('book.index',['books'=>$b_table]);
    }


    public function postBook(Request $request){
        $data = $request->all();
       // dd($data);

        $have_book = [];
        $log_array = [];
        $want_book = $data['want_book'];
        $temp_have_book=$data['have_book'];
        foreach ($temp_have_book as $key => $value) {
            if($value!=''&&$value>0){
                for ($x = 1; $x <= $value; $x++) {
                    array_push($have_book, $key);
                } 
            }
        }

      

        $book = \App\models\bookTable::with('relatives')
                                ->where('id',$want_book)
                                ->first();
        $books= \App\models\bookTable::all();
        foreach ($books as $key => $b) {
            $book_map[$b->name] = $b->id;
            # code...
        }

        $new_arr = [
            'log_array' => $log_array,
            'have_book' => $have_book
        ];
        
        $tp_arr = $this->ChildInfo($book,$new_arr);

        $rt_array = $tp_arr['log_array'];
        $le_arr = array_count_values($tp_arr['have_book']);
        // dd($rt_array);
        echo($book->level." 級天書 " . $book->name);
        
        foreach ($rt_array as $key => $value) {
            if($book->level!=$key){
                echo('<br>');
                echo("需要 ".$key." 級天書");
                $temp_arr = array_count_values($value);
                foreach ($temp_arr as $k => $v) {
                    if($key!=1){
                        echo("</br>".$k.'  '.$v.'本');
                    }
                    else{
                        $need_qty = (intval($v)*2);
                        $need_id = $book_map[$k];
                        if(isset($le_arr[$need_id])){
                            $need_qty = $need_qty - $le_arr[$need_id];
                        }
                        
                        echo("</br>".$k.'  '.$need_qty.'本');
                    }
                }
            }
            echo('<br>');
        }
    }



    public function ChildInfo($book,$arr){
        $log_array = $arr['log_array'];
        $have_book = $arr['have_book'];


        if($book->level>1){
            if (($key = array_search($book->id, $have_book)) !== false) {
                unset($have_book[$key]);
                $new_arr = [
                    'log_array' => $log_array,
                    'have_book' => $have_book
                ];
                return $new_arr;
            }
        }
        $log_array[$book->level][]=$book->name;

        if(count($book->relatives)>0){
            foreach ($book->relatives as $key => $relative) {
                $c_book = $relative->Book;
                $new_arr = [
                    'log_array' => $log_array,
                    'have_book' => $have_book
                ];

                $tp = $this->ChildInfo($c_book,$new_arr);


                $log_array = $tp['log_array'];
                $have_book = $tp['have_book'];
            }

        }

        $new_arr = [
            'log_array' => $log_array,
            'have_book' => $have_book
        ];
        return $new_arr;
    }


    public function getQuestion(){
        return View('book.question');
    }

    public function postQuestion(Request $request,$str){
        
        $url = "https://sdk.xyapi.game.qq.com/api/xiaoyue/public/qa/search?_=1571385183145&gameId=1313&keyword=".$str."&page=1&pageSize=100&callback=jsonp_cb_12";
 
        $ch = curl_init();
         
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
         
        curl_close($ch);
        $output = str_replace('/**/jsonp_cb_12(', '', $output);
        $output = str_replace(')', '', $output);
       
        return response()->json(json_decode($output));
        return $output;
         
    }



    public function U_getHeader($url_array){
        $time_start = microtime(true);
        foreach ($url_array as $key => $value) {
            $headers = get_headers($value, 1);
            \Log::debug('Get url : '.$value);
            if(isset($headers[0])&&$headers[0]=='HTTP/1.0 200 OK'){
                    \Log::debug('Get url : '.$value.'  success.');
            }
        }

        $time = microtime(true) - $time_start;

        dd($time);
        //118.74162387848
    }

    public function getC(){
        set_time_limit(0);
        $urls = [];
        $min_date = date('Ymd', strtotime(date('Ymd') . ' -1 day'));
        $max_date = date('Ymd', strtotime(date('Ymd') . ' +3 day'));
        $min_page = 23420;
        $max_page = 23480;
        for($i = $min_date;   $i<=$max_date; $i =  date('Ymd', strtotime($i . ' +1 day'))){
            for($v = (int)$min_page;$v<=$max_page;$v++){
                $url = 'https://pwm.iwplay.com.tw/NewsList/newsbulletin/'.$i.'/'.$v.'.html';
                $urls[] = $url;
            }
        }
       
        $this->U_getHeader($urls);
        dd('ZZ');
       




    }


  

}