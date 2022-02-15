<?php 

use Illuminate\Support\Facades\Route;
use Rancor\Forums\Http\Controllers\GroupController;
use Rancor\Forums\Http\Controllers\CategoryController;
use Rancor\Forums\Http\Controllers\BoardController;
use Rancor\Forums\Http\Controllers\DiscussionController;
use Rancor\Forums\Http\Controllers\ReplyController;
use Rancor\Forums\Http\Controllers\ForumController;

Route::group(['middleware' => ['web']], function(){
   
   $middleware = array_merge(config('rancor.middleware.web'), ['admin']);

   Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => $middleware ], function() {
      Route::post('groups/search', [GroupController::class, 'search'])->name('groups.search');
      Route::post('categories/search', [CategoryController::class, 'search'])->name('categories.search');
      Route::post('boards/search', [BoardController::class, 'search'])->name('boards.search');
      Route::post('discussions/search', [DiscussionController::class, 'search'])->name('discussions.search');
      Route::resource('groups', GroupController::class);
      Route::resource('categories', CategoryController::class);
      Route::resource('boards', BoardController::class);
      Route::resource('discussions', DiscussionController::class)->except('create','store');
   });
   
   Route::group(['prefix' => 'forums', 'as' => 'forums.', 'middleware' => config('rancor.middleware.web')], function() {
      Route::get('/', [ForumController::class,'index'])->name('index');
      Route::get('unread', [ForumController::class, 'unread'])->name('unread.index');
      Route::post('unread', [ForumController::class, 'markread'])->name('unread.mark');
      Route::resource('discussions', DiscussionController::class)->only('create','store');
      Route::resource('replies', ReplyController::class)->except('show','index');
      Route::get('{category:slug}', [ForumController::class, 'category'])->name('category');
      Route::get('{category:slug}/{board:slug}', [ForumController::class, 'board'])->name('board');
      Route::get('{category:slug}/{board:slug}/{discussion}', [ForumController::class, 'discussion'])->name('discussion');
   });

   Route::get('profile/{user}/replies', [ReplyController::class, 'index'])->name('profile.replies');
});

