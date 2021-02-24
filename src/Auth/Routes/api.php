<?php 
$middleware = array_merge(['api'],config('rancor.middleware.web'));

Route::group(['namespace' => 'AndrykVP\Rancor\Auth\Http\Controllers\API', 'prefix' => 'api', 'as' => 'api.', 'middleware' => $middleware ], function(){
	Route::apiResource('users', 'UserController')->except(['store']);
	Route::apiResource('roles', 'RoleController');
	Route::post('users/search', 'UserController@search')->name('users.search');
});