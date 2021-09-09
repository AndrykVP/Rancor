<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use AndrykVP\Rancor\Forums\Models\Reply;
use AndrykVP\Rancor\Forums\Http\Resources\ReplyResource;
use AndrykVP\Rancor\Forums\Http\Requests\EditReplyForm;
use AndrykVP\Rancor\Forums\Http\Requests\NewReplyForm;

class ReplyController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $replies = $user->replies()
                        ->with('discussion.board.category')
                        ->paginate(config('rancor.pagination'));

        return ReplyResource::collection($replies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\ReplyForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewReplyForm $request)
    {
        $this->authorize('create',Reply::class);
        
        $data = $request->validated();
        $reply = Reply::create($data);

        return response()->json([
            'message' => 'Reply has been posted'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Models\Reply  $reply
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
     * @param  \AndrykVP\Rancor\Forums\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(EditReplyForm $request, Reply $reply)
    {
        $this->authorize('update',$reply);
        
        $data = $request->validated();
        $reply->update($data);

        return response()->json([
            'message' => 'Reply #'.$reply->id.' has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Models\Reply  $reply
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