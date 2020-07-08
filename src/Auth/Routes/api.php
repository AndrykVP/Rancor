<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Auth\Http\Controllers', 'prefix' => 'api', 'middleware' => ['api']], function(){
	Route::resource('user', 'UserController')->except(['create','edit','store']);
});