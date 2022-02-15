<?php 

use Illuminate\Support\Facades\Route;
use Rancor\Scanner\Http\Controllers\ScannerController;
use Rancor\Scanner\Http\Controllers\EntryController;
use Rancor\Scanner\Http\Controllers\TerritoryTypeController;

$middleware = array_merge(['web'], config('rancor.middleware.web'));

Route::group(['middleware' => $middleware], function() {

	Route::group(['prefix' => 'scanner', 'as' => 'scanner.'], function(){
		Route::get('/', [ScannerController::class, 'index'])->name('index');
		Route::get('upload', [ScannerController::class, 'create'])->name('create');
		Route::post('upload', [ScannerController::class, 'store'])->name('store');
		Route::post('search', [ScannerController::class, 'search'])->name('search');
		Route::get('{quadrant}', [ScannerController::class, 'quadrant'])->name('quadrants');
		Route::get('territories/{territory}', [ScannerController::class, 'territory'])->name('territories');
		Route::post('territories/{territory}/update', [ScannerController::class, 'update'])->name('update');
	});

	Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function() {
		Route::post('entries/search', [EntryController::class, 'search'])->name('entries.search');
		Route::post('territorytypes/search', [TerritoryTypeController::class, 'search'])->name('territorytypes.search');
		Route::resource('entries', EntryController::class);
		Route::resource('territorytypes', TerritoryTypeController::class);
	});
});

