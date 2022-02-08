<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Auth\Http\Controllers\UserController;
use AndrykVP\Rancor\Auth\Http\Controllers\RoleController;
use AndrykVP\Rancor\Auth\Http\Controllers\PermissionController;
use AndrykVP\Rancor\Auth\Http\Controllers\ProfileController;

Route::group(['middleware' => ['web']], function(){

	Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => 'auth', 'controller' => ProfileController::class], function() {
		Route::get('/', 'index')->name('index');
		Route::get('edit', 'edit')->name('edit');
		Route::patch('edit', 'update')->name('update');
		Route::get('{user}', 'show')->name('show');
	});

	Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => array_merge(config('rancor.middleware.web'), ['admin'])], function() {
		Route::patch('users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
		Route::post('users/search', [UserController::class, 'search'])->name('users.search');
		Route::post('roles/search', [RoleController::class, 'search'])->name('roles.search');
		Route::post('permissions/search', [PermissionController::class, 'search'])->name('permissions.search');
		Route::resource('users', UserController::class)->except(['create','store']);
		Route::resource('roles', RoleController::class);
		Route::resource('permissions', PermissionController::class);
	});
});