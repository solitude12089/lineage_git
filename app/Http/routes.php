<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::auth();

Route::get('/home', 'HomeController@index');

Route::match(['get', 'post'], 'register', function(){
    return redirect('/');
});
Route::group(['middleware' => 'auth'], function(){
	Route::get('/', function () {
    	return view('welcome');
	});
	Route::controller('fileserver', 'FileserverController');
	Route::controller('role', 'RoleController');
	Route::controller('killer', 'KillerController');
	Route::controller('treasure', 'TreasureController');
	Route::controller('import', 'ImportController');
	Route::controller('self', 'SelfController');
	Route::controller('export', 'ExportController');
	Route::controller('guild', 'GuildController');
	Route::controller('general', 'GeneralController');
	Route::controller('user', 'UserController');
	Route::controller('salary', 'SalaryController');
	Route::controller('question', 'QuestionController');
	Route::controller('report', 'ReportController');
	Route::controller('offset', 'OffsetController');
	Route::controller('rank', 'RankController');
	Route::controller('auction', 'AuctionController');
	Route::controller('publicmoney', 'PublicmoneyController');
	Route::controller('message', 'MessageController');
	Route::controller('cross', 'CrossController');
});
