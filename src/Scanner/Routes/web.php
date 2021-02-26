<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Scanner\Http\Controllers', 'prefix' => 'scanner', 'middleware' => ['web']], function(){
	Route::get('/','ScannerController@index')->name('scanner.index');
	Route::post('search','ScannerController@search')->name('scanner.search');
	Route::resources([
		'entries' => 'EntryController',
	]);
});