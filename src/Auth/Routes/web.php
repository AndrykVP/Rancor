<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Auth\Http\Controllers', 'middleware' => ['web']], function(){
	Route::resource('users', 'UserController')->except(['create','store']);
	Route::resource('roles', 'RoleController')->except('show');
	Route::resource('permissions', 'PermissionController')->except('show');
});