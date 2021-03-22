<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Holocron\Http\Controllers\API\NodeController;
use AndrykVP\Rancor\Holocron\Http\Controllers\API\CollectionController;

$middleware = array_merge(['api'],config('rancor.middleware.api'),['admin']);

Route::group(['prefix' => 'api/holocron', 'as' => 'api.holocron.', 'middleware' => $middleware], function(){
	Route::post('collections/search', [CollectionController::class, 'search'])->name('collections.search');
	Route::post('nodes/search', [NodeController::class, 'search'])->name('nodes.search');
	Route::apiResources([
		'collections' => CollectionController::class,
		'nodes' => NodeController::class,
	]);
});