<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Auth\Http\Controllers\API', 'prefix' => 'api', 'middleware' => ['api']], function(){
	Route::apiResource('users', 'UserController')->except(['store']);
	Route::apiResource('roles', 'RoleController');
	Route::post('users/search', 'UserController@search')->name('users.search');
});