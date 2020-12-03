<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Board;
use AndrykVP\Rancor\Forums\Category;
use AndrykVP\Rancor\Forums\Discussion;
use AndrykVP\Rancor\Forums\Reply;
use AndrykVP\Rancor\Forums\Events\VisitDiscussion;
use Auth;

class ForumController extends Controller
{
   /**
    * Construct Controller
    * 
    * @return void
    */
   public function __construct()
   {
      $this->middleware('auth');
   }
   
   /**
    * Display a listing of parent categories.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $boards = Auth::user()->topics();

      $categories = Category::whereHas('boards', function($query) use($boards) {
         $query->whereIn('id', $boards);
      })->with(['boards' => function($query) use($boards) {
         $query->whereIn('id',$boards)
               ->where('parent_id',null)
               ->withCount('discussions','replies')
               ->with('latest_reply','children')
               ->orderBy('order');
      }])->withCount('boards')->get();

      return view('rancor::forums.index',['categories' => $categories]);
   }

   /**
    * Display a listing of parent categories.
    *
    * @return \Illuminate\Http\Response
    */
   public function category(Category $category)
   { 
      $this->authorize('view',$category);

      $boards = Auth::user()->topics();

      $category->load(['boards' => function($query) use($boards) {
         $query->whereIn('id',$boards)
               ->where('parent_id',null)
               ->withCount('discussions','replies')
               ->with('latest_reply','children')
               ->orderBy('order');
      }])->loadCount('boards');

      return view('rancor::forums.category',['category' => $category]);
   }
   
   /**
    * Display the specified Board.
    *
    * @return \Illuminate\Http\Response
    */
   public function board(Category $category, Board $board)
   {
      $this->authorize('view',$board);

      $board->load('category','moderators')->load(['children' => function($query) {
         $query->withCount('discussions','replies','children')->with('latest_reply')->orderBy('order');
      }]);

      $sticky = Discussion::withCount('replies')->where([
         ['board_id',$board->id],
         ['is_sticky',true],
      ])->get();

      $normal = Discussion::withCount('replies')->where([
         ['board_id',$board->id],
         ['is_sticky',false],
      ])->paginate(config('rancor.forums.pagination'));

      return view('rancor::forums.Board',['board' => $board, 'sticky' => $sticky, 'normal' => $normal]);
   }
   
   /**
    * Display the specified discussion.
    *
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

      $discussion->load('board.category');

      $replies = $discussion->replies()->with(['author' => function($query) {
         $query->with('rank.department')->withCount('replies');
      }])->paginate(config('rancor.forums.pagination'));

      return view('rancor::forums.discussion',['discussion' => $discussion, 'replies' => $replies ]);
   }
   
   /**
    * Add a new discussion to the specified board.
    *
    * @return \Illuminate\Http\Response
    */
   public function unread(Request $request)
   {
      $user = $request->user();
      $categories = $user->getCategoryIDs();
      $unread = $user->unreadDiscussions()
               ->with('board.category','author','latest_reply')
               ->withCount('replies')
               ->paginate(config('rancor.forums.pagination'));

      return view('rancor::forums.unread',['discussions' => $unread]);
   }

   /**
    * Add a new discussion to the specified board.
    *
    * @return \Illuminate\Http\Response
    */
   public function markread(Request $request)
   {
      $unread = $request->user()->unreadDiscussions()->detach();

      return redirect()->route('forums.unread')->with('success','All unread replies have been successfully marked read');
   }
}