<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Structure\Http\Controllers\API\FactionController;
use AndrykVP\Rancor\Structure\Http\Controllers\API\DepartmentController;
use AndrykVP\Rancor\Structure\Http\Controllers\API\RankController;
use AndrykVP\Rancor\Structure\Http\Controllers\API\AwardController;
use AndrykVP\Rancor\Structure\Http\Controllers\API\TypeController;

$middleware = array_merge(['api'],config('rancor.middleware.api'), ['admin']);

Route::group(['prefix' => 'api/structure', 'as' => 'api.structure.', 'middleware' => $middleware], function(){
	Route::post('awards/search', [AwardController::class, 'search'])->name('awards.search');
	Route::post('departments/search', [DepartmentController::class, 'search'])->name('departments.search');
	Route::post('factions/search', [FactionController::class, 'search'])->name('factions.search');
	Route::post('ranks/search', [RankController::class, 'search'])->name('ranks.search');
	Route::post('types/search', [TypeController::class, 'search'])->name('types.search');
	Route::apiResources([
		'factions' => FactionController::class,
		'departments' => DepartmentController::class,
		'ranks' => RankController::class,
		'awards' => AwardController::class,
		'types' => TypeController::class,
	]);
});