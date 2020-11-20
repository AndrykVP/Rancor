<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Board;
use AndrykVP\Rancor\Forums\Category;
use AndrykVP\Rancor\Forums\Discussion;
use AndrykVP\Rancor\Forums\Reply;
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
      $this->middleware('forum.board')->only('board');
      $this->middleware('forum.discussion')->only('discussion');
   }
   
   /**
    * Display a listing of parent categories.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $user_categories = Auth::user()->getCategoryIDs();

      $categories = Category::whereIn('id',$user_categories)->with(['boards' => function($query) {
         $query->withCount('discussions','replies','children')->with('latest_reply')->where('parent_id',null)->orderBy('order');
      }])->get();

      return view('rancor.forums::index',['categories' => $categories]);
   }

   /**
    * Display a listing of parent categories.
    *
    * @return \Illuminate\Http\Response
    */
    public function category($slug)
    { 
       $categories = Category::where('slug',$slug)->with(['boards' => function($query) {
          $query->withCount('discussions','replies','children')->with('latest_reply')->where('parent_id',null)->orderBy('order');
       }])->get();
 
       return view('rancor.forums::index',['categories' => $categories]);
    }
   
   /**
    * Display the specified Board.
    *
    * @return \Illuminate\Http\Response
    */
   public function board($slug)
   {
      $board = Board::with(['children' => function($query) {
         $query->withCount('discussions','replies','children')->with('latest_reply')->orderBy('order');
      }])->where('slug',$slug)->first();

      $sticky = Discussion::withCount('replies')->where([
         ['board_id',$board->id],
         ['is_sticky',true],
      ])->get();

      $normal = Discussion::withCount('replies')->where([
         ['board_id',$board->id],
         ['is_sticky',false],
      ])->get();

      return view('rancor.forums::Board',['board' => $board, 'sticky' => $sticky, 'normal' => $normal]);
   }
   
   /**
    * Display the specified discussion.
    *
    * @return \Illuminate\Http\Response
    */
   public function discussion($id)
   {
      $discussion = Discussion::with('board')->find($id);
      $replies = Reply::with('author')->where('discussion_id',$id)->paginate(20);

      return view('rancor.forums::discussion',['discussion' => $discussion, 'replies' => $replies ]);
   }
}