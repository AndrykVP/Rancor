<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Audit\Http\Controllers\API\LogController;

$middleware = array_merge(['api', config('rancor.midleware.api')]);

Route::group(['prefix' => 'api\audit', 'as' => 'api.audit.', 'middleware' => $middleware], function(){
	Route::get('users/{id}', [LogController::class, 'users'])->name('users');
	Route::get('ips/{id}', [LogController::class, 'ips'])->name('ips');
});