<?php 

use Illuminate\Support\Facades\Route;
use Rancor\Scanner\Http\Controllers\API\EntryController;
use Rancor\Scanner\Http\Controllers\API\TerritoryTypeController;

$middleware = array_merge(['api'],config('rancor.middleware.api'),['admin']);

Route::group(['prefix' => 'api/scanner', 'as' => 'api.scanner.', 'middleware' => $middleware], function(){
	Route::post('entries/search', [EntryController::class, 'search'])->name('entries.search');
	Route::post('territorytypes/search', [TerritoryTypeController::class, 'search'])->name('territorytypes.search');
	Route::apiResources([
		'entries' => EntryController::class,
		'territorytypes' => TerritoryTypeController::class,
	]);
});