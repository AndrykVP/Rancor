<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Structure\Http\Controllers\FactionController;
use AndrykVP\Rancor\Structure\Http\Controllers\DepartmentController;
use AndrykVP\Rancor\Structure\Http\Controllers\RankController;
use AndrykVP\Rancor\Structure\Http\Controllers\AwardController;
use AndrykVP\Rancor\Structure\Http\Controllers\AwardTypeController;

$middleware = array_merge(['web'],config('rancor.middleware.web'), ['admin']);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => $middleware ], function(){
	Route::post('factions/search', [FactionController::class, 'search'])->name('factions.search');
	Route::post('departments/search', [DepartmentController::class, 'search'])->name('departments.search');
	Route::post('ranks/search', [RankController::class, 'search'])->name('ranks.search');
	Route::post('awards/search', [AwardController::class, 'search'])->name('awards.search');
	Route::post('awardtypes/search', [AwardTypeController::class, 'search'])->name('awardtypes.search');
	Route::resources([
		'factions' => FactionController::class,
		'departments' => DepartmentController::class,
		'ranks' => RankController::class,
		'awards' => AwardController::class,
		'awardtypes' => AwardTypeController::class,
	]);
});