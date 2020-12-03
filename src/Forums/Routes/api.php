<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Forums\Http\Controllers\API', 'prefix' => 'api/forums', 'middleware' => ['api']], function(){
   Route::apiResources([
      'boards' => 'BoardController',
      'categories' => 'CategoryController',
      'discussions' => 'DiscussionController',
      'groups' => 'GroupController',
      'replies' => 'ReplyController',
   ]);
});