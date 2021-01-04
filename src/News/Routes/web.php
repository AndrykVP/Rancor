<?php 
$middleware = array_merge(['web'],config('rancor.middleware.web'), ['admin']);

Route::group(['namespace' => 'AndrykVP\Rancor\News\Http\Controllers', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => $middleware ], function(){
	Route::resources([
		'articles' => 'ArticleController',
		'tags' => 'TagController',
	]);
});