<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\News\Http\Controllers\ArticleController;
use AndrykVP\Rancor\News\Http\Controllers\TagController;
use AndrykVP\Rancor\News\Http\Controllers\NewsController;

$middleware = array_merge(['web'],config('rancor.middleware.web'), ['admin']);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => $middleware] , function(){
	Route::post('articles/search', [ArticleController::class, 'search'])->name('articles.search');
	Route::post('tags/search', [TagController::class, 'search'])->name('tags.search');
	Route::resources([
		'articles' => ArticleController::class,
		'tags' => TagController::class,
	]);
});

Route::group(['prefix' => 'news', 'as' => 'news.', 'middleware' => 'web'], function(){
	Route::get('/', [NewsController::class ,'index'])->name('index');
	Route::get('/drafts', [NewsController::class ,'drafts'])->name('drafts');
	Route::get('/tagged/{tag}', [NewsController::class ,'tagged'])->name('tagged');
	Route::get('/{article}', [NewsController::class ,'show'])->name('show');
});