<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Auth\Http\Controllers\API\UserController;
use AndrykVP\Rancor\Auth\Http\Controllers\API\RoleController;

$middleware = array_merge(['api'],config('rancor.middleware.web'));

Route::group(['prefix' => 'api\auth', 'as' => 'api.auth.', 'middleware' => $middleware ], function(){
	Route::apiResource('users', UserController::class)->except(['store']);
	Route::apiResource('roles', RoleController::class);
	Route::post('users/search', [UserController::class, 'search'])->name('users.search');
});