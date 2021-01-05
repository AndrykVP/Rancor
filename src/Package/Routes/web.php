<?php 

use App\User;
use AndrykVP\Rancor\News\Article;
use AndrykVP\Rancor\News\Tag;
use AndrykVP\Rancor\Forums\Group;
use AndrykVP\Rancor\Forums\Category;
use AndrykVP\Rancor\Forums\Board;
use AndrykVP\Rancor\Forums\Discussion;
use AndrykVP\Rancor\Forums\Reply;

Route::group(['middleware' => array_merge(['web'], config('rancor.middleware.web'), ['admin'])], function(){

   Route::get('admin',function() {

      $cards = [
         [
            'title' => 'Users',
            'value' => User::count()
         ],
         [
            'title' => 'Articles',
            'value' => Article::count()
         ],
         [
            'title' => 'Tags',
            'value' => Tag::count()
         ],
         [
            'title' => 'Groups',
            'value' => Group::count()
         ],
         [
            'title' => 'Categories',
            'value' => Category::count()
         ],
         [
            'title' => 'Boards',
            'value' => Board::count()
         ],
         [
            'title' => 'Discussions',
            'value' => Discussion::count()
         ],
         [
            'title' => 'Replies',
            'value' => Reply::count()
         ],
      ];

      return view('rancor::dashboard', compact('cards'));
   })->name('admin.index');

});