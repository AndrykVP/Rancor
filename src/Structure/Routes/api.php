<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Structure\Http\Controllers\API\FactionController;
use AndrykVP\Rancor\Structure\Http\Controllers\API\DepartmentController;
use AndrykVP\Rancor\Structure\Http\Controllers\API\RankController;
use AndrykVP\Rancor\Structure\Http\Controllers\API\AwardController;
use AndrykVP\Rancor\Structure\Http\Controllers\API\TypeController;

$middleware = array_merge(['api'],config('rancor.middleware.api'), ['admin']);

Route::group(['prefix' => 'api/structure', 'as' => 'api.structure.', 'middleware' => $middleware], function(){
	Route::apiResources([
		'factions' => FactionController::class,
		'departments' => DepartmentController::class,
		'ranks' => RankController::class,
		'awards' => AwardController::class,
		'types' => TypeController::class,
	]);
});