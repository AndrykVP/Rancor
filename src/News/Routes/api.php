<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\News\Http\Controllers', 'prefix' => 'api', 'middleware' => ['api']], function(){
	Route::apiResources([
		'articles' => 'ArticleController',
	]);
	Route::get('articles/public', 'ArticleController@public');
	Route::get('articles/drafts', 'ArticleController@drafts');
});