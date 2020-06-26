<?php 

use AndrykVP\SWC\Models\Planet;
use App\User;

Route::group(['namespace' => 'AndrykVP\SWC\Http\Controllers', 'middleware' => ['web']], function(){
	Route::get('dev', function() {
		$user = User::find(1);
		
		IDGen::makeAvatar($user,'default');
	});
});