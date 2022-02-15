<?php

namespace Rancor\Forums\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Rancor\Forums\Models\Category;
use Rancor\Forums\Models\Board;
use Rancor\Forums\Models\Discussion;
use Rancor\Forums\Events\VisitDiscussion;

class ForumController extends Controller
{   
   /**
    * Display a listing of parent categories.
    *
    * @param \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      $boards = $request->user()->topics();

      $categories = Category::whereHas('boards', function (Builder $query) use($boards) {
         $query->whereIn('id', $boards);
      })->with(['boards' => function($query) use($boards) {
         $query->topTier()
               ->whereIn('id',$boards)
               ->withCount('discussions','replies')
               ->with('category','latest_reply.discussion','children', 'moderators')
               ->orderBy('lineup');
      }])->withCount('boards')->get();

      $unread_discussions = $request->user()->discussions()
      ->whereHas('board', function($query) use($boards) {
         $query->whereIn('id', $boards);
      })
      ->get()
      ->groupBy('board_id')
      ->transform(function($item, $key) {
         $unread = $item->pluck('unread');
         return $unread->reduce(function ($carry, $item) {
            return $carry + $item['reply_count'];
         });
      });

      return view('rancor::forums.index',compact('categories', 'unread_discussions'));
   }
   
   /**
    * Displays all unread discussions.
    *
    * @param \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function unread(Request $request)
   {
      $unread = $request->user()->discussions()
               ->whereHas('board', function($query) use($request) {
                  $query->whereIn('id', $request->user()->topics());
               })
               ->with('board.category','author','latest_reply')
               ->withCount('replies')
               ->paginate(config('rancor.forums.pagination'));

      return view('rancor::forums.unread', compact('unread'));
   }

   /**
    * Marks all unread discussions as read.
    *
    * @param \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function markread(Request $request)
   {
      $user = $request->user();

      $unread = DB::table('forum_unread_discussions')
      ->where('user_id', $user->id)
      ->whereIn('discussion_id', function($query) use($user) {
         $query->select('id')
         ->from('forum_discussions')
         ->whereIn('board_id', $user->topics());
      })
      ->update([
         'updated_at' => now(),
         'reply_count' => 0,
      ]);

      return redirect()->route('forums.unread.index')->with('alert', [
         'message' => 'All Discussions have been marked as read'
      ]);
   }

   /**
    * Display the specified Category.
    *
    * @param \Illuminate\Http\Request  $request
    * @param \Rancor\Forums\Models\Category  $category;
    * @return \Illuminate\Http\Response
    */
   public function category(Request $request, Category $category)
   {
      $this->authorize('view', $category);

      $boards = $request->user()->topics();

      $unread_discussions = $request->user()->discussions()->whereHas('board', function(Builder $query) use ($boards, $category) {
         $query->whereIn('id', $boards)
         ->where('category_id', $category->id);
      })->get()
      ->groupBy('board_id')
      ->transform(function($item, $key) {
         $unread = $item->pluck('unread');
         if($unread->isEmpty()) return 0;
         
         return $unread->reduce(function ($carry, $item) {
            return $carry + $item['reply_count'];
         });
      });

      $category->load(['boards' => function($query) use($boards) {
         $query->topTier()
               ->whereIn('id', $boards)
               ->withCount('discussions', 'replies')
               ->with('category', 'latest_reply.discussion', 'children', 'moderators')
               ->orderBy('lineup');
      }])->loadCount('boards')->get();
      
      return view('rancor::forums.category', compact('category', 'unread_discussions'));
   }

   /**
    * Display the specified Board.
    *
    * @param \Illuminate\Http\Request  $request
    * @param \Rancor\Forums\Models\Category  $category;
    * @param \Rancor\Forums\Models\Board  $board;
    * @return \Illuminate\Http\Response
    */
   public function board(Request $request, Category $category, Board $board)
   {
      $this->authorize('view', $board);

      $board->load('moderators')->load(['children' => function($query) {
         $query->withCount('discussions','replies','children')->with('latest_reply.discussion')->orderBy('lineup');
      }]);

      $sticky = $board->discussions()
                 ->sticky()
                 ->withCount('replies')
                 ->with(['visitors' => function($query) use($request) {
                    $query->where('user_id', $request->user()->id);
                 }])
                 ->with('latest_reply.discussion')
                 ->get();

      $normal = $board->discussions()
                 ->sticky(false)
                 ->withCount('replies')
                 ->with(['visitors' => function($query) use($request) {
                    $query->where('user_id', $request->user()->id);
                 }])
                 ->with('latest_reply.discussion')
                 ->paginate(config('rancor.forums.pagination'));

      return view('rancor::forums.board',compact('category', 'board', 'sticky', 'normal'));
   }

   /**
    * Display the specified Discussion.
    *
    * @param \Rancor\Forums\Models\Category  $category;
    * @param \Rancor\Forums\Models\Board  $board;
    * @param  \Rancor\Forums\Models\Discussion  $discussion
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