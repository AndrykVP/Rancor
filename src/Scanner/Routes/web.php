<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Scanner\Http\Controllers\ScannerController;
use AndrykVP\Rancor\Scanner\Http\Controllers\EntryController;

$middleware = array_merge(['web'], config('rancor.middleware.web'));

Route::group(['prefix' => 'scanner', 'as' => 'scanner.', 'middleware' => $middleware], function(){

	Route::post('entries/search', [EntryController::class, 'search'])->name('entries.search');
	Route::resource('entries', EntryController::class);
	// Route::get('/', [ScannerController::class, 'index'])->name('index');
	// Route::post('/', [ScannerController::class, 'search'])->name('search');
	// Route::get('create', [EntryController::class, 'create'])->name('create');
	// Route::post('create', [EntryController::class, 'store'])->name('store');
	// Route::get('{entry}', [ScannerController::class, 'show'])->name('show');


});
