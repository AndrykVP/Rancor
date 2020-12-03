<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use AndrykVP\Rancor\Forums\Reply;
use AndrykVP\Rancor\Forums\Discussion;
use AndrykVP\Rancor\Forums\Http\Requests\ReplyForm;

class ReplyController extends Controller
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
     * @param \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $this->authorize('viewAny',Reply::class);
        $replies = $user->replies()->with('discussion.board.category')->latest()->paginate(config('rancor.forums.pagination'));
        
        return view('rancor::replies.index',compact('replies','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create',Reply::class);
        $discussion = Discussion::with('board.category')->find($request->discussion);
        $quote = Reply::with('author')->where('id',$request->quote)->first();

        return view('rancor::replies.create',['discussion' => $discussion, 'quote' => $quote]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\ReplyForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReplyForm $request)
    {
        $this->authorize('create',Reply::class);
        
        $data = $request->validated();
        $reply = Reply::create($data);

        $page = $reply->discussion()->withCount('replies')->pluck('replies_count')->first();
        $page = $page > 0 ? ceil($page / config('rancor.forums.pagination')) : 1;

        return redirect()->route('forums.discussion',['category' => $reply->discussion->board->category->slug,'board' => $reply->discussion->board->slug,'discussion' => $reply->discussion->id,'page' => $page ])->with('success', 'Reply has been successfully posted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        $this->authorize('view',$reply);

        return view('rancor::replies.show',['reply' => $reply->load('category','groups')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply, Request $request)
    {
        $this->authorize('update', $reply);
        $discussion = $reply->discussion()->with('board.category')->first();

        return view('rancor::replies.edit',['discussion' => $discussion, 'reply' => $reply]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\ReplyForm  $request
     * @param  \AndrykVP\Rancor\Forums\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(ReplyForm $request, Reply $reply)
    {
        $this->authorize('update',$reply);
        
        $data = $request->validated();
        $reply->update($data);

        $reply->groups()->sync($data['groups']);

        return redirect()->route('forums.Replys.index')->with('success', 'Reply "'.$reply->title.'" has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('delete',$reply);
        
        $reply->delete();

        return redirect()->route('forums.Replys.index')->with('success', 'Reply "'.$reply->title.'" has been successfully deleted');
    }
}