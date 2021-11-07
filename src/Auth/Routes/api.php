<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Auth\Http\Controllers\API\UserController;
use AndrykVP\Rancor\Auth\Http\Controllers\API\RoleController;
use AndrykVP\Rancor\Auth\Http\Controllers\API\PermissionController;

$middleware = array_merge(['api'],config('rancor.middleware.api'),['admin']);

Route::group(['prefix' => 'api/auth', 'as' => 'api.auth.', 'middleware' => $middleware ], function(){
	Route::patch('users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
	Route::post('users/search', [UserController::class, 'search'])->name('users.search');
	Route::post('roles/search', [RoleController::class, 'search'])->name('roles.search');
	Route::post('permissions/search', [PermissionController::class, 'search'])->name('permissions.search');
	Route::apiResource('users', UserController::class)->except(['store']);
	Route::apiResource('roles', RoleController::class);
	Route::apiResource('permissions', PermissionController::class);
});