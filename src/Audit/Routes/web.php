<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Audit\Http\Controllers\LogController;

$middleware = array_merge(['web'], config('rancor.middleware.web'), ['admin']);

Route::group(['prefix' => 'audit', 'as' => 'audit.', 'middleware' => $middleware, 'controller' => LogController::class], function(){
	Route::get('/', 'index')->name('index');
	Route::get('users/{user}', 'users')->name('users');
	Route::get('ips/{user}', 'ips')->name('ips');
	Route::get('bans/{user}', 'bans')->name('bans');
	Route::get('nodes/{node}', 'nodes')->name('nodes');
	Route::get('entries/{entry}', 'entries')->name('entries');
});