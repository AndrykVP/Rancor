<?php 

use Illuminate\Support\Facades\Route;
use Rancor\Forums\Http\Controllers\API\BoardController;
use Rancor\Forums\Http\Controllers\API\CategoryController;
use Rancor\Forums\Http\Controllers\API\DiscussionController;
use Rancor\Forums\Http\Controllers\API\GroupController;
use Rancor\Forums\Http\Controllers\API\ReplyController;

$middleware = array_merge(['api'],config('rancor.middleware.api'),['admin']);

Route::group(['prefix' => 'api/forums', 'as' => 'api.forums.', 'middleware' => $middleware], function(){
	Route::post('boards/search', [BoardController::class, 'search'])->name('boards.search');
	Route::post('categories/search', [CategoryController::class, 'search'])->name('categories.search');
	Route::post('discussions/search', [DiscussionController::class, 'search'])->name('discussions.search');
	Route::post('groups/search', [GroupController::class, 'search'])->name('groups.search');
	Route::apiResources([
		'boards' => BoardController::class,
		'categories' => CategoryController::class,
		'discussions' => DiscussionController::class,
		'groups' => GroupController::class,
		'replies' => ReplyController::class,
	]);
});