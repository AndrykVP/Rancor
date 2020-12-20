<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Scanner\Http\Controllers\API', 'prefix' => 'api/scanner', 'middleware' => ['api']], function(){
	Route::post('search','EntryController@search');
	Route::apiResources([
		'entries' => 'EntryController',
	]);
});