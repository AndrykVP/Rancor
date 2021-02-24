<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\News\Http\Controllers\API', 'prefix' => 'api', 'as' => 'api.', 'middleware' => ['api']], function(){
	Route::apiResources([
		'articles' => 'ArticleController',
		'tags' => 'TagController',
	]);
	Route::get('articles/public', 'ArticleController@public');
	Route::get('articles/drafts', 'ArticleController@drafts');
});