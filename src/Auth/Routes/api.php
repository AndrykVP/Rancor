<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Auth\Http\Controllers', 'prefix' => 'api', 'middleware' => ['api']], function(){
	Route::apiResources([
		'user' => 'UserController',
	]);
});