<?php 

use Illuminate\Support\Facades\Route;
use Rancor\Audit\Http\Controllers\UserLogController;
use App\Models\User;

$middleware = array_merge(['web'], config('rancor.middleware.web'));

Route::group(['prefix' => 'audit', 'as' => 'audit.', 'middleware' => $middleware], function(){
	Route::get('users/{user}', [UserLogController::class, 'users'])->name('users');
	Route::get('ips/{user}', [UserLogController::class, 'ips'])->name('ips');
});