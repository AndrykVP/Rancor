<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Scanner\Http\Controllers', 'prefix' => 'scanner', 'middleware' => ['web']], function(){
	Route::post('search','EntryController@search');
	Route::resources([
		'entries' => 'EntryController',
	]);
});