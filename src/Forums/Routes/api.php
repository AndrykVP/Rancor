<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Forums\Http\Controllers', 'prefix' => 'api/forums', 'middleware' => ['api']], function(){
   Route::apiResources([
      'boards' => 'BoardController',
      'categorys' => 'CategoryController',
      'discussions' => 'DiscussionController',
      'groups' => 'GroupController',
      'replies' => 'ReplyController',
   ]);
});