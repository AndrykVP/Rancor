<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\News\Http\Controllers\API\ArticleController;
use AndrykVP\Rancor\News\Http\Controllers\API\TagController;

$middleware = array_merge(['api'],config('rancor.middleware.api'),['admin']);

Route::group(['prefix' => 'api/news', 'as' => 'api.news.', 'middleware' => $middleware], function(){
	Route::post('articles/search', [ArticleController::class, 'search'])->name('articles.search');
	Route::post('tags/search', [TagController::class, 'search'])->name('tags.search');
	Route::apiResources([
		'articles' => ArticleController::class,
		'tags' => TagController::class,
	]);
});