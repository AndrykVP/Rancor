<?php 
$middleware = array_merge(['api'],config('rancor.middleware.api'));

Route::group(['namespace' => 'AndrykVP\Rancor\Holocron\Http\Controllers\API', 'prefix' => 'api\holocron', 'as' => 'api.holocron.', 'middleware' => $middleware], function(){
	
	Route::apiResources([
		'nodes' => 'NodeController',
		'collections' => 'CollectionController',
	]);
});