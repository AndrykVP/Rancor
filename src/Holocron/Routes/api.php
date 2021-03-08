<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Holocron\Http\Controllers\API\NodeController;
use AndrykVP\Rancor\Holocron\Http\Controllers\API\CollectionController;

$middleware = array_merge(['api'],config('rancor.middleware.api'));

Route::group(['prefix' => 'api\holocron', 'as' => 'api.holocron.', 'middleware' => $middleware], function(){
	
	Route::apiResources([
		'nodes' => NodeController::class,
		'collections' => CollectionController::class,
	]);
});