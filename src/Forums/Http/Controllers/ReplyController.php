<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Reply;
use AndrykVP\Rancor\Forums\Http\Resources\ReplyResource;
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
        $this->middleware(config('rancor.middleware'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $replies = Reply::all()->paginate(20);

        return ReplyResource::collection($replies);
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
        
        $data = $request->all();
        $reply = Reply::create([
            'body' => $data['body'],
            'discussion_id' => $data['discussion_id'],
            'author_id' => $data['user_id'],
        ]);

        return response()->json([
            'message' => 'Reply has been posted'
        ], 200);
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

        return new ReplyResource($reply->load('author','discussion','editor'));
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
        
        $data = $request->all();
        $reply->update([
            'body' => $data['body'],
            'discussion_id' => $data['discussion_id'],
            'editor_id' => $data['user_id'],
        ]);

        return response()->json([
            'message' => 'Reply #'.$reply->id.' has been updated'
        ], 200);
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

        return response()->json([
            'message' => 'Reply #'.$reply->id.' has been deleted'
        ], 200);        
    }
}