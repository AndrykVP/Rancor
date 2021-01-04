<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Category;
use AndrykVP\Rancor\Forums\Board;
use AndrykVP\Rancor\Forums\Discussion;
use AndrykVP\Rancor\Forums\Events\VisitDiscussion;
use Auth;

class ForumController extends Controller
{   
   /**
    * Display a listing of parent categories.
    *
    * @param \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $boards = Auth::user()->topics();
      $categories = Auth::user()->categories();

      $categories = Category::whereIn('id',$categories)->with(['boards' => function($query) use($boards) {
         $query->topTier()
               ->whereIn('id',$boards)
               ->withCount('discussions','replies')
               ->with('latest_reply','children')
               ->orderBy('order');
      }])->withCount('boards')->get();

      return view('rancor::forums.index',compact('categories'));
   }
   
   /**
    * Add a new discussion to the specified board.
    *
    * @param \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function unread(Request $request)
   {
      $unread = $request->user()->unreadDiscussions()
               ->with('board.category','author','latest_reply')
               ->withCount('replies')
               ->paginate(config('rancor.forums.pagination'));

      return view('rancor::forums.unread', compact('unread'));
   }

   /**
    * Add a new discussion to the specified board.
    *
    * @param \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function markread(Request $request)
   {
      $unread = $request->user()->unreadDiscussions()->detach();

      return redirect()->route('forums.unread.index')->with('alert','All unread replies have been successfully marked read');
   }

   /**
    * Display the specified Category.
    *
    * @param \Illuminate\Http\Request  $request
    * @param \AndrykVP\Rancor\Forums\Category  $category;
    * @return \Illuminate\Http\Response
    */
   public function category(Request $request, Category $category)
   {
      $this->authorize('view', $category);

      $boards = $request->user()->topics();

      $category->load(['boards' => function($query) use($boards) {
         $query->topTier()
               ->whereIn('id',$boards)
               ->withCount('discussions','replies')
               ->with('latest_reply','children')
               ->orderBy('order');
      }])->loadCount('boards')->get();
      
      return view('rancor::forums.category', compact('category'));
   }

   /**
    * Display the specified Board.
    *
    * @param \AndrykVP\Rancor\Forums\Category  $category;
    * @param \AndrykVP\Rancor\Forums\Board  $board;
    * @return \Illuminate\Http\Response
    */
   public function board(Category $category, Board $board)
   {
      $this->authorize('view', $board);

      $board->load('moderators')->load(['children' => function($query) {
         $query->withCount('discussions','replies','children')->with('latest_reply.discussion')->orderBy('order');
      }]);

      $sticky = $board->discussions()
                 ->sticky()
                 ->withCount('replies')
                 ->get();

      $normal = $board->discussions()
                 ->sticky(false)
                 ->withCount('replies')
                 ->paginate(config('rancor.forums.pagination'));

      return view('rancor::forums.board',compact('category','board','sticky','normal'));
   }

   /**
    * Display the specified Discussion.
    *
    * @param \AndrykVP\Rancor\Forums\Category  $category;
    * @param \AndrykVP\Rancor\Forums\Board  $board;
    * @param  \AndrykVP\Rancor\Forums\Discussion  $discussion
    * @return \Illuminate\Http\Response
    */
   public function discussion(Category $category, Board $board, Discussion $discussion)
   {
      $this->authorize('view',$discussion);

      event(new VisitDiscussion($discussion));
      if(!in_array($discussion->id, session()->get('visited_discussions',array())))
      {
         session()->push('visited_discussions',$discussion->id);
      }

      $board->load('moderators');

      $replies = $discussion->replies()->with('editor')->with(['author' => function($query) {
         $query->with('rank.department')->withCount('replies');
      }])->paginate(config('rancor.pagination'));

      return view('rancor::forums.discussion',compact('category','board','discussion','replies'));
   }
}