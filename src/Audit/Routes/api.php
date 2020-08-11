<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Audit\Http\Controllers', 'prefix' => 'audit', 'middleware' => ['api']], function(){
	Route::get('users/{id}', 'LogController@users')->name('audit.users');
	Route::get('ips/{id}', 'LogController@ips')->name('audit.ips');
});