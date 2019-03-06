<?php
namespace App\Http\Controllers;

//use Request;
use Illuminate\Http\Request;
use Auth;
use \Cache;




class FileserverController extends Controller
{


	public function bytesToSize($bytes) {
	   $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
	   if ($bytes == 0) return '0 Byte';
	   $i = intval(floor(log($bytes) / log(1024)));
	   // dd($i);
	   return round($bytes / pow(1024, $i), 2) . ' ' . $sizes[$i];
	}


	//回傳檔案
	public function getDownload($filename)  
	{

		$file_data = \App\models\attachment::where('unique_name','=',$filename)
													 	  ->first();
 	  	$url = $_SERVER['DOCUMENT_ROOT'].'/files/'.$file_data->disk_directory.'/'.$file_data->disk_filename;
  		$headers = array(
              'Content-Type: '.$file_data->mimetype,
            );
		return response()->download($url,$file_data->filename, $headers);
	}
	

	/*
	回傳路徑
	下載到本地端->直接回傳路徑
	用於 <img src
	*/
	public function Path_by_Download($filename)  
	{
		// var_dump($filename);

		if($filename==null||strlen($filename)==0)
		{
			// var_dump('Null');
			// dd($filename);
			return null;
		}
		

		$file_data = \App\models\fileserver\attachment::where('unique_name','=',$filename)
													 	  ->first();

 	  	if($file_data==null)
 	  		return null;
 	  	$url = $_SERVER['DOCUMENT_ROOT'].'/FileserverCache/'.$filename;
 	  	$url2 = '/FileserverCache/'.$filename;


		if(!file_exists($url))
		{
			// var_dump('run_Path_by_Download');
	 	  	$host = config('fileserver')['host'];
	 	  	$username = config('fileserver')['username'];
	 	  	$password = config('fileserver')['password'];
			$file_path = 'ftp://'.$username.':'.$password.'@'.$host.'/upload/common/'.$file_data->disk_directory.'/'.$file_data->disk_filename;
			// dd($file_path);
			$ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $file_path);
		    curl_setopt($ch, CURLOPT_VERBOSE, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
		    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		    curl_setopt($ch, CURLOPT_HEADER, 0);
		    curl_setopt($ch, CURLOPT_TIMEOUT, 600);
		    $result = curl_exec($ch);
		    curl_close($ch);
	       	$fp = fopen($_SERVER['DOCUMENT_ROOT'].'/FileserverCache/'.$filename, 'w');
		    fwrite($fp, $result);
		    fclose($fp);
		    // Cache::rememberForever($filename,);
	    }
  		
  		
        return $url2;
	}





	public function getDownloadbyname(Request $request)  
	{

		$data = $request->all();
		$filename = basename($data['path']);
		$rt_path = $_SERVER['DOCUMENT_ROOT'].'/FileserverCache/'.$data['path'];
		
		if(!file_exists($rt_path))
		{
			$dir = $_SERVER['DOCUMENT_ROOT'].'/FileserverCache/'.substr($data['path'],0,strlen($data['path'])-strlen($filename)-1);
			// var_dump($dir);
			if (!file_exists($dir)) {
			    mkdir($dir, 0777, true);
			}
			// var_dump('run_Path_by_Download');
	 	  	$host = config('fileserver')['host'];
	 	  	$username = config('fileserver')['username'];
	 	  	$password = config('fileserver')['password'];
			$file_path = 'ftp://'.$username.':'.$password.'@'.$host.'/'.$data['path'];// dd($file_path);
			$ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $file_path);
		    curl_setopt($ch, CURLOPT_VERBOSE, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
		    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		    curl_setopt($ch, CURLOPT_HEADER, 0);
		    curl_setopt($ch, CURLOPT_TIMEOUT, 600);
		    $result = curl_exec($ch);
		    curl_close($ch);
	       	$fp = fopen($rt_path, 'w');
		    fwrite($fp, $result);
		    fclose($fp);
		}

		header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
        header("Cache-Control: public");
        header("Content-Transfer-Encoding: Binary");
        header("Content-Length:".filesize($rt_path));
        header("Content-Disposition: attachment;");
        readfile($rt_path);
	}

	public function upload($file,$note_id,$type)  
	{
		try
		{

			$user = Auth::user();
			
			$upload_time = date("YmdHis");
			$disk_directory = date("Ym");

			$attachment = new \App\models\attachment;
			$attachment->type = $type;
			$attachment->target_id = $note_id;
			$attachment->unique_name = md5(uniqid(rand()));
			$attachment->filename = $file->getClientOriginalName();
			$attachment->mimetype = $file->getClientMimeType();
			$attachment->disk_filename = $upload_time.$file->getClientOriginalName();
			$attachment->disk_directory = $disk_directory;
			$attachment->filesize =$this->bytesToSize($file->getClientsize());
			$attachment->username =$user->name;

			$attachment->save();
			
		    $destination_path = $_SERVER['DOCUMENT_ROOT'].'/files/'.$disk_directory.'/';
		    if (!file_exists($destination_path)) {
			    mkdir($destination_path, 0777, true);
			}
			//dd($file,$destination_path);

			if(file_exists($destination_path.$upload_time.$file->getClientOriginalName())){
				return $attachment->unique_name ;
			}
				
	        $upload_success = $file->move($destination_path, $upload_time.$file->getClientOriginalName());

			return $attachment->unique_name ;
			
		} 
		catch (Exception $e) 
		{
			dd($e);
		}
	}

	public function upload_m($file,$note_ids,$type)  
	{
		try
		{

			$user = Auth::user();
			
			$upload_time = date("YmdHis");
			$disk_directory = date("Ym");

			foreach ($note_ids as $key => $note_id) {
				$attachment = new \App\models\attachment;
				$attachment->type = $type;
				$attachment->target_id = $note_id;
				$attachment->unique_name = md5(uniqid(rand()));
				$attachment->filename = $file->getClientOriginalName();
				$attachment->mimetype = $file->getClientMimeType();
				$attachment->disk_filename = $upload_time.$file->getClientOriginalName();
				$attachment->disk_directory = $disk_directory;
				$attachment->filesize =$this->bytesToSize($file->getClientsize());
				$attachment->username =$user->name;

				$attachment->save();
			}
			
			
		    $destination_path = $_SERVER['DOCUMENT_ROOT'].'/files/'.$disk_directory.'/';
		    if (!file_exists($destination_path)) {
			    mkdir($destination_path, 0777, true);
			}
			//dd($file,$destination_path);

			if(file_exists($destination_path.$upload_time.$file->getClientOriginalName())){
				return $attachment->unique_name ;
			}
				
	        $upload_success = $file->move($destination_path, $upload_time.$file->getClientOriginalName());

			return $attachment->unique_name ;
			
		} 
		catch (Exception $e) 
		{
			dd($e);
		}
	}







}