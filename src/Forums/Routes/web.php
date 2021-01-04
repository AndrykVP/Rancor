<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Forums\Http\Controllers', 'middleware' => ['web']], function(){
   
   $middleware = array_merge(config('rancor.middleware.web'), ['admin']);

   Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => $middleware ], function() {
      Route::resource('groups','GroupController');
      Route::resource('categories','CategoryController');
      Route::resource('boards','BoardController');
      Route::resource('discussions','DiscussionController')->except('create','store');
   });
   
   Route::group(['prefix' => 'forums', 'as' => 'forums.', 'middleware' => config('rancor.middleware.web')], function() {
      Route::get('/','ForumController@index')->name('index');
      Route::get('unread','ForumController@unread')->name('unread.index');
      Route::post('unread','ForumController@markread')->name('unread.mark');
      Route::get('discussions/create','DiscussionController@create')->name('discussions.create');
      Route::post('discussions/create','DiscussionController@store')->name('discussions.store');
      Route::resource('replies','ReplyController')->except('show','index');
      Route::get('{category:slug}','ForumController@category')->name('category');
      Route::get('{category:slug}/{board:slug}','ForumController@board')->name('board');
      Route::get('{category:slug}/{board:slug}/{discussion}','ForumController@discussion')->name('discussion');
   });

   Route::get('/profile/{user}/replies','ReplyController@index')->name('replies.index');
});

