<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Discussion;
use AndrykVP\Rancor\Forums\Http\Resources\DiscussionResource;
use AndrykVP\Rancor\Forums\Http\Requests\DiscussionForm;

class DiscussionController extends Controller
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
        $discussions = Discussion::paginate(20);

        return DiscussionResource::collection($discussions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\DiscussionForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscussionForm $request)
    {
        $this->authorize('create',Discussion::class);
        
        $data = $request->validated();
        $discussion = Discussion::create([
            'title' => $data['title'],
            'is_sticky' => $data['is_sticky'],
            'board_id' => $data['board_id'],
            'author_id' => $data['user_id'],
        ]);

        return response()->json([
            'message' => 'Discussion "'.$discussion->title.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function show(Discussion $discussion)
    {
        $this->authorize('view',$discussion);

        return new DiscussionResource($discussion->load('author','board', 'replies', 'latest_reply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\DiscussionForm  $request
     * @param  \AndrykVP\Rancor\Forums\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function update(DiscussionForm $request, Discussion $discussion)
    {
        $this->authorize('update',$discussion);
        
        $data = $request->validated();
        $discussion->update([
            'title' => $data['title'],
            'is_sticky' => $data['is_sticky'],
            'board_id' => $data['board_id'],
            'editor_id' => $data['user_id'],
        ]);

        return response()->json([
            'message' => 'Discussion "'.$discussion->title.'" has been updated'
        ], 200);
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

        return response()->json([
            'message' => 'Discussion "'.$discussion->title.'" has been deleted'
        ], 200);        
    }
}