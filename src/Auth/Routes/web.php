<?php 
Route::group(['namespace' => 'AndrykVP\Rancor\Auth\Http\Controllers', 'middleware' => array_merge(['web'],config('rancor.middleware.web'))], function(){

	Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function() {
		Route::resource('users', 'UserController')->except(['create','store']);
		Route::resource('roles', 'RoleController');
		Route::resource('permissions', 'PermissionController');
	});

	Route::get('profile/{user}', 'ProfileController@index')->name('profile.index');
	// Route::get('profile/edit', 'UserController@edit')->name('profile.edit');
	// Route::patch('profile/edit', 'UserController@update')->name('profile.update');
});