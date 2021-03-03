<?php 
Route::group(['namespace' => 'AndrykVP\Rancor\Holocron\Http\Controllers' ], function(){
	$middleware = array_merge(['web'],config('rancor.middleware.web'), ['admin']);
	
	Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => $middleware] , function(){
		Route::resources([
			'nodes' => 'NodeController',
			'collections' => 'CollectionController',
		]);
	});

	Route::group(['prefix' => 'holocron', 'as' => 'holocron.', 'middleware' => 'web'], function(){
		Route::get('/', 'HolocronController@index')->name('index');
		Route::get('/collections','HolocronController@collection_index')->name('collection.index');
		Route::get('/nodes','HolocronController@node_index')->name('node.index');
		Route::get('/collections/{collection:slug}','HolocronController@collection_show')->name('collection.show');
		Route::get('/nodes/{node}','HolocronController@node_show')->name('node.show');
	});
});