<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Scanner\Http\Controllers', 'middleware' => ['web']], function(){

	Route::group(['prefix' => 'scanner', 'as' => 'scanner.', 'middleware' => config('rancor.middleware.web')], function() {
		Route::get('','ScannerController@index')->name('index');
		Route::post('','ScannerController@search')->name('search');
		Route::get('upload','ScannerController@upload')->name('upload');
		Route::post('upload','ScannerController@store')->name('store');
		Route::get('{entry}','ScannerController@show')->name('show');
	});

	$middleware = array_merge(config('rancor.middleware.web'), ['admin']);
	
	Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => $middleware], function(){
		Route::resource('entries', 'EntryController')->except('store','create');
	});
});
