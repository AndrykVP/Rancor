<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Forums\Http\Controllers', 'as' => 'forums.', 'middleware' => ['web']], function(){
   
   Route::prefix('forums')->group(function() {
      Route::resource('categories','CategoryController')->except('show');
      Route::resource('boards','BoardController')->except('show');
      Route::resource('discussions','DiscussionController')->except('show');
      Route::resource('replies','ReplyController')->except('show','index');
      Route::resource('groups','GroupController')->except('show');
      Route::get('{category:slug}','CategoryController@show')->name('categories.show');
      Route::get('{category:slug}/{board:slug}','BoardController@show')->name('boards.show');
      Route::get('{category:slug}/{board:slug}/{discussion}','DiscussionController@show')->name('discussions.show');
      
      Route::get('/','ForumController@index')->name('index');
      Route::get('unread','ForumController@unread')->name('unread');
      Route::get('markread','ForumController@markread')->name('markread');
   });
   Route::get('/profile/{user}/replies','ReplyController@index')->name('replies.index');
});

