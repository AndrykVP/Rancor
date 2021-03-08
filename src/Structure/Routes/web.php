<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Structure\Http\Controllers\FactionController;
use AndrykVP\Rancor\Structure\Http\Controllers\DepartmentController;
use AndrykVP\Rancor\Structure\Http\Controllers\RankController;
use AndrykVP\Rancor\Structure\Http\Controllers\AwardController;
use AndrykVP\Rancor\Structure\Http\Controllers\TypeController;

$middleware = array_merge(['web'],config('rancor.middleware.web'), ['admin']);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => $middleware ], function(){
	Route::resources([
		'factions' => FactionController::class,
		'departments' => DepartmentController::class,
		'ranks' => RankController::class,
		'awards' => AwardController::class,
		'types' => TypeController::class,
	]);
});