<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Audit\Http\Controllers\API\UserLogController;

$middleware = array_merge(['api'], config('rancor.middleware.api'), ['admin']);

Route::group(['prefix' => 'api/audit', 'as' => 'api.audit.', 'middleware' => $middleware], function(){
	Route::get('users/{user}', [UserLogController::class, 'users'])->name('users');
	Route::get('ips/{user}', [UserLogController::class, 'ips'])->name('ips');
});