<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\News\Http\Controllers', 'prefix' => 'news', 'middleware' => ['web']], function(){
	Route::resources([
		'articles' => 'ArticleController',
		'tags' => 'TagController',
	]);
});