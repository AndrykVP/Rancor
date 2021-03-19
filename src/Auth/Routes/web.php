<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Auth\Http\Controllers\UserController;
use AndrykVP\Rancor\Auth\Http\Controllers\RoleController;
use AndrykVP\Rancor\Auth\Http\Controllers\PermissionController;
use AndrykVP\Rancor\Auth\Http\Controllers\ProfileController;

Route::group(['middleware' => array_merge(['web'],config('rancor.middleware.web'))], function(){

	Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function() {
		Route::post('users/search', [UserController::class, 'search'])->name('users.search');
		Route::post('roles/search', [RoleController::class, 'search'])->name('roles.search');
		Route::post('permissions/search', [PermissionController::class, 'search'])->name('permissions.search');
		Route::resource('users', UserController::class)->except(['create','store']);
		Route::resource('roles', RoleController::class);
		Route::resource('permissions', PermissionController::class);
	});

	Route::group(['prefix' => 'profile', 'as' => 'profile.'], function() {
		Route::get('/', [ProfileController::class, 'index'])->name('index');
		Route::get('{user}', [ProfileController::class, 'show'])->name('show');
		Route::get('{user}/edit', [ProfileController::class, 'edit'])->name('edit');
		Route::patch('{user}/edit', [ProfileController::class, 'update'])->name('update');
	});

});