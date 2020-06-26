<?php 

use App\User;

Route::group(['namespace' => 'AndrykVP\Rancor\Auth\Routes', 'middleware' => ['web']], function(){
	Route::get('dev', function() {
		print_r('Hello World');
		//$user = User::find(1);
		//IDGen::makeAvatar($user,'default');
	});
});