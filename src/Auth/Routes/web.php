<?php 
Route::group(['namespace' => 'AndrykVP\Rancor\Auth\Http\Controllers', 'middleware' => array_merge(['web'],config('rancor.middleware.web'))], function(){

	Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function() {
		Route::resource('users', 'UserController')->except(['create','store']);
		Route::resource('roles', 'RoleController');
		Route::resource('permissions', 'PermissionController');
	});

	Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => config('rancor.middleware.web')], function() {
		Route::get('/', 'ProfileController@index')->name('index');
		Route::get('edit', 'ProfileController@edit')->name('edit');
		Route::patch('edit', 'ProfileController@update')->name('update');
		Route::get('{user}', 'ProfileController@show')->name('show');
	});

});