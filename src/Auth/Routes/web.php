<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Auth\Http\Controllers\UserController;
use AndrykVP\Rancor\Auth\Http\Controllers\RoleController;
use AndrykVP\Rancor\Auth\Http\Controllers\PermissionController;
use AndrykVP\Rancor\Auth\Http\Controllers\ProfileController;

Route::group(['middleware' => array_merge(['web'],config('rancor.middleware.web'))], function(){

	Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function() {
		Route::resource('users', UserController::class)->except(['create','store']);
		Route::resource('roles', RoleController::class);
		Route::resource('permissions', PermissionController::class);
	});

	Route::group(['prefix' => 'profile', 'as' => 'profile.'], function() {
		Route::get('/', [ProfileController::class, 'index'])->name('index');
		Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
		Route::patch('edit', [ProfileController::class, 'update'])->name('update');
		Route::get('{user}', [ProfileController::class, 'show'])->name('show');
	});

});