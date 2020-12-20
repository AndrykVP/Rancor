<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Scanner\Http\Controllers', 'prefix' => 'api/scanner', 'middleware' => ['api']], function(){
	Route::post('search','EntryController@search');
	Route::apiResources([
		'entries' => 'EntryController',
	]);
});