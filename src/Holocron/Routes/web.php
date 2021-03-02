<?php 
$middleware = array_merge(['web'],config('rancor.middleware.web'));

Route::group(['namespace' => 'AndrykVP\Rancor\Holocron\Http\Controllers', 'prefix' => 'holocron', 'as' => 'holocron.', 'middleware' => $middleware], function(){
	
	Route::resources([
		'nodes' => 'NodeController',
		'collections' => 'CollectionController',
	]);
});