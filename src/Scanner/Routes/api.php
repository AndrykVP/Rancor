<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Scanner\Http\Controllers\API\EntryController;

$middleware = array_merge(['api'],config('rancor.middleware.api'),['admin']);

Route::group(['prefix' => 'api/scanner', 'as' => 'api.scanner.', 'middleware' => $middleware], function(){
	Route::post('entries/search', [EntryController::class, 'search'])->name('entries.search');
	Route::apiResources([
		'entries' => EntryController::class,
	]);
});