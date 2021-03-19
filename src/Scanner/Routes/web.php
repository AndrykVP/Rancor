<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Scanner\Http\Controllers\ScannerController;
use AndrykVP\Rancor\Scanner\Http\Controllers\EntryController;

Route::group(['middleware' => ['web']], function(){

	Route::group(['prefix' => 'scanner', 'as' => 'scanner.', 'middleware' => config('rancor.middleware.web')], function() {
		Route::get('/', [ScannerController::class, 'index'])->name('index');
		Route::post('/', [ScannerController::class, 'search'])->name('search');
		Route::get('upload', [ScannerController::class, 'upload'])->name('upload');
		Route::post('upload', [ScannerController::class, 'store'])->name('store');
		Route::get('{entry}', [ScannerController::class, 'show'])->name('show');
	});

	$middleware = array_merge(config('rancor.middleware.web'), ['admin']);
	
	Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => $middleware], function(){
		Route::post('entries/search', [EntryController::class, 'search'])->name('entries.search');
		Route::resource('entries', EntryController::class)->except('store','create');
	});
});
