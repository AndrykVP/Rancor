<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\News\Http\Controllers\API\ArticleController;
use AndrykVP\Rancor\News\Http\Controllers\API\TagController;

Route::group(['prefix' => 'api', 'as' => 'api.', 'middleware' => ['api']], function(){
	Route::apiResources([
		'articles' => ArticleController::class,
		'tags' => TagController::class,
	]);
});