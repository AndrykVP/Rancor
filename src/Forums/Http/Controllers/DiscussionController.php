<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Discussion;
use AndrykVP\Rancor\Forums\Category;
use AndrykVP\Rancor\Forums\Board;
use AndrykVP\Rancor\Forums\Reply;
use AndrykVP\Rancor\Forums\Events\VisitDiscussion;
use AndrykVP\Rancor\Forums\Http\Requests\NewDiscussionForm;
use AndrykVP\Rancor\Forums\Http\Requests\EditDiscussionForm;

class DiscussionController extends Controller
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
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Discussion::class);

        $discussions = Discussion::with('category')->orderBy('category_id')->orderBy('order')->get();
        
        return view('rancor::discussions.index',['discussions' => $discussions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create',Discussion::class);
        $board = Board::with('category')->find($request->board);

        return view('rancor::discussions.create',['board' => $board]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\NewDiscussionForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewDiscussionForm $request)
    {
        $this->authorize('create',Discussion::class);
        
        $data = $request->validated();
        $discussion = Discussion::create($data);
        $discussion->replies()->create($data);

        $discussion->load('board.category');

        return redirect()->route('forums.discussions.show',['category' => $discussion->board->category, 'board' => $discussion->board, 'discussion' => $discussion])->with('success', 'Discussion "'.$discussion->title.'" has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Board $board, Discussion $discussion)
    {
        $this->authorize('view',$discussion);

        event(new VisitDiscussion($discussion));
        if(!in_array($discussion->id, session()->get('visited_discussions',array())))
        {
            session()->push('visited_discussions',$discussion->id);
        }

        $board->load('moderators');
  
        $replies = $discussion->replies()->with(['author' => function($query) {
           $query->with('rank.department')->withCount('replies');
        }])->paginate(config('rancor.forums.pagination'));
  
        return view('rancor::discussions.show',compact('category','board','discussion','replies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Discussion $discussion)
    {
        $this->authorize('update', $discussion);
        $topics = $request->user()->topics();
        $boards = Board::whereIn('id',$topics)->orderBy('title')->get();
        $discussion->load('board.category');

        return view('rancor::discussions.edit',compact('discussion', 'boards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\EditDiscussionForm  $request
     * @param  \AndrykVP\Rancor\Forums\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function update(EditDiscussionForm $request, Discussion $discussion)
    {
        $this->authorize('update',$discussion);
        
        $data = $request->validated();
        $discussion->update($data);

        return redirect()->route('forums.discussions.show',['category' => $discussion->board->category, 'board' => $discussion->board, 'discussion' => $discussion])->with('success', 'Discussion "'.$discussion->title.'" has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discussion $discussion)
    {
        $this->authorize('delete',$discussion);
        
        $discussion->delete();

        return redirect()->route('forums.discussions.index')->with('success', 'discussion "'.$discussion->title.'" has been successfully deleted');
    }
}