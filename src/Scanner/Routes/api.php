<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Scanner\Http\Controllers\API\EntryController;

Route::group(['prefix' => 'api/scanner', 'as' => 'api.scanner.', 'middleware' => ['api']], function(){
	Route::post('search', [EntryController::class, 'search']);
	Route::apiResources([
		'entries' => EntryController::class,
	]);
});