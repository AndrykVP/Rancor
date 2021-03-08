<?php 

use Illuminate\Support\Facades\Route;
use AndrykVP\Rancor\Forums\Http\Controllers\API\BoardController;
use AndrykVP\Rancor\Forums\Http\Controllers\API\CategoryController;
use AndrykVP\Rancor\Forums\Http\Controllers\API\DiscussionController;
use AndrykVP\Rancor\Forums\Http\Controllers\API\GroupController;
use AndrykVP\Rancor\Forums\Http\Controllers\API\ReplyController;

Route::group(['prefix' => 'api\forums', 'as' => 'api.forums.', 'middleware' => ['api']], function(){
   Route::apiResources([
      'boards' => BoardController::class,
      'categories' => CategoryController::class,
      'discussions' => DiscussionController::class,
      'groups' => GroupController::class,
      'replies' => ReplyController::class,
   ]);
});