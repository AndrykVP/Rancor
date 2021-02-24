<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\News\Http\Controllers' ], function(){
	$middleware = array_merge(['web'],config('rancor.middleware.web'), ['admin']);
	
	Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => $middleware] , function(){
		Route::resources([
			'articles' => 'ArticleController',
			'tags' => 'TagController',
		]);
	});

	Route::group(['prefix' => 'news', 'as' => 'news.', 'middleware' => 'web'], function(){
		Route::get('/', 'NewsController@index')->name('index');
		Route::get('/drafts', 'NewsController@drafts')->name('drafts');
		Route::get('/tagged/{tag}','NewsController@tagged')->name('tagged');
	});
});