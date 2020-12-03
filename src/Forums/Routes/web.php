<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Forums\Http\Controllers', 'prefix' => 'forums', 'as' => 'forums.', 'middleware' => ['web']], function(){
   Route::resources([
      'boards' => 'BoardController',
      'categories' => 'CategoryController',
      // 'discussions' => 'DiscussionController',
      // 'groups' => 'GroupController',
      'replies' => 'ReplyController',
   ]);
   
   Route::get('/','ForumController@index')->name('index');
   Route::get('unread','ForumController@unread')->name('unread');
   Route::get('markread','ForumController@markread')->name('markread');
   Route::get('{category:slug}','ForumController@category')->name('category');
   Route::get('{category:slug}/{board:slug}','ForumController@board')->name('board');
   Route::get('{category:slug}/{board:slug}/{discussion}','ForumController@discussion')->name('discussion');
});

