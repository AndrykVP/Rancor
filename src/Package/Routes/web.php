<?php 

use Illuminate\Support\Facades\Route;
use App\Models\User;
use AndrykVP\Rancor\News\Models\Article;
use AndrykVP\Rancor\News\Models\Tag;
use AndrykVP\Rancor\Forums\Models\Group;
use AndrykVP\Rancor\Forums\Models\Category;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Discussion;
use AndrykVP\Rancor\Forums\Models\Reply;

Route::group(['middleware' => array_merge(['web'], config('rancor.middleware.web'), ['admin'])], function(){

   Route::get('admin',function() {

      $cards = [
         [
            'title' => 'Users',
            'value' => User::count(),
            'icon' => 'user-group'
         ],
         [
            'title' => 'Articles',
            'value' => Article::count(),
            'icon' => 'newspaper'
         ],
         [
            'title' => 'Tags',
            'value' => Tag::count(),
            'icon' => 'tag'
         ],
         [
            'title' => 'Groups',
            'value' => Group::count(),
            'icon' => 'key'
         ],
         [
            'title' => 'Categories',
            'value' => Category::count(),
            'icon' => 'collection'
         ],
         [
            'title' => 'Boards',
            'value' => Board::count(),
            'icon' => 'table'
         ],
         [
            'title' => 'Discussions',
            'value' => Discussion::count(),
            'icon' => 'chat-alt-2'
         ],
         [
            'title' => 'Replies',
            'value' => Reply::count(),
            'icon' => 'chat'
         ],
      ];

      return view('rancor::dashboard', compact('cards'));
   })->name('admin.index');

});