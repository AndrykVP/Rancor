<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\News\Http\Controllers', 'prefix' => 'api', 'middleware' => ['api']], function(){
	Route::apiResources([
		'articles' => 'ArticleController',
	]);
	Route::resource('news', 'NewsController')->only(['index','show']);
});