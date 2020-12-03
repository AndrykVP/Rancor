<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Category;
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
      $categories = Auth::user()->categories();

      $categories = Category::whereIn('id',$categories)->with(['boards' => function($query) use($boards) {
         $query->whereIn('id',$boards)
               ->where('parent_id',null)
               ->withCount('discussions','replies')
               ->with('latest_reply','children')
               ->orderBy('order');
      }])->withCount('boards')->get();

      return view('rancor::forums.index',['categories' => $categories]);
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