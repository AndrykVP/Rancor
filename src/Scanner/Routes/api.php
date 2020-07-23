<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Scanner\Http\Controllers', 'prefix' => 'api', 'middleware' => ['api']], function(){
	Route::apiResources([
		'scans' => 'EntryController',
	]);
	Route::post('scans/search','EntryController@search');
});