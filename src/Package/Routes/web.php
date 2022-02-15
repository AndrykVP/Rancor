<?php 

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Rancor\News\Models\Article;
use Rancor\News\Models\Tag;
use Rancor\Forums\Models\Group;
use Rancor\Forums\Models\Category;
use Rancor\Forums\Models\Board;
use Rancor\Forums\Models\Discussion;
use Rancor\Forums\Models\Reply;
use Rancor\Holocron\Models\Node;
use Rancor\Holocron\Models\Collection;
use Rancor\Scanner\Models\Entry;

Route::group(['middleware' => array_merge(['web'], config('rancor.middleware.web'), ['admin'])], function(){

   Route::get('admin',function() {

      $cards = [
         [
            'title' => 'Users',
            'value' => User::count(),
            'icon' => 'users'
         ],
         [
            'title' => 'Forum Groups',
            'value' => Group::count(),
            'icon' => 'user-group'
         ],
         [
            'title' => 'Forum Categories',
            'value' => Category::count(),
            'icon' => 'folder-open'
         ],
         [
            'title' => 'Forum Boards',
            'value' => Board::count(),
            'icon' => 'table'
         ],
         [
            'title' => 'Forum Discussions',
            'value' => Discussion::count(),
            'icon' => 'chat-alt-2'
         ],
         [
            'title' => 'Forum Replies',
            'value' => Reply::count(),
            'icon' => 'chat'
         ],
         [
            'title' => 'Holocron Nodes',
            'value' => Node::count(),
            'icon' => 'book-open'
         ],
         [
            'title' => 'Holocron Collections',
            'value' => Collection::count(),
            'icon' => 'collection'
         ],
         [
            'title' => 'News Articles',
            'value' => Article::count(),
            'icon' => 'newspaper'
         ],
         [
            'title' => 'News Tags',
            'value' => Tag::count(),
            'icon' => 'tag'
         ],
         [
            'title' => 'Scanner Entries',
            'value' => Entry::count(),
            'icon' => 'status-online'
         ],
      ];

      return view('rancor::dashboard', compact('cards'));
   })->name('admin.index');

});