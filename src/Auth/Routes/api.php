<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Auth\Http\Controllers', 'prefix' => 'api', 'middleware' => ['api']], function(){
	Route::resource('users', 'UserController')->except(['create','edit','store']);
});