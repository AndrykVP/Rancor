<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Scanner\Http\Controllers', 'prefix' => 'scanner', 'as' => 'scanner.', 'middleware' => ['web']], function(){
	Route::get('','ScannerController@index')->name('index');
	Route::post('','ScannerController@search')->name('search');
	Route::get('upload','ScannerController@upload')->name('upload');
	Route::post('upload','ScannerController@store')->name('store');
});

Route::group(['namespace' => 'AndrykVP\Rancor\Scanner\Http\Controllers', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['web']], function(){
	Route::resource('entries', 'EntryController')->except('store','create');
});