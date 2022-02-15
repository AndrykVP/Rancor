<?php

namespace Rancor\Forums\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rancor\Forums\Models\Discussion;
use Rancor\Forums\Http\Resources\DiscussionResource;
use Rancor\Forums\Http\Requests\DiscussionSearch;
use Rancor\Forums\Http\Requests\EditDiscussionForm;
use Rancor\Forums\Http\Requests\NewDiscussionForm;

class DiscussionController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discussions = Discussion::with('author', 'board', 'latest_reply')
                    ->paginate(config('rancor.pagination'));

        return DiscussionResource::collection($discussions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Rancor\Forums\Http\Requests\DiscussionForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewDiscussionForm $request)
    {
        $this->authorize('create', Discussion::class);
        
        $data = $request->validated();
        $discussion = Discussion::create($data);

        return response()->json([
            'message' => 'Discussion "' . $discussion->name . '" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Rancor\Forums\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function show(Discussion $discussion)
    {
        $this->authorize('view', $discussion);

        return new DiscussionResource($discussion->load('author', 'board', 'latest_reply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Rancor\Forums\Http\Requests\DiscussionForm  $request
     * @param  \Rancor\Forums\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function update(EditDiscussionForm $request, Discussion $discussion)
    {
        $this->authorize('update',$discussion);
        
        $data = $request->validated();
        $discussion->update($data);

        return response()->json([
            'message' => 'Discussion "' . $discussion->name . '" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Rancor\Forums\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discussion $discussion)
    {
        $this->authorize('delete', $discussion);
        
        $discussion->delete();

        return response()->json([
            'message' => 'Discussion "' . $discussion->name . '" has been deleted'
        ], 200);        
    }

    /**
     * Display the results that match the search query.
     *
     * @param  \Rancor\Forums\Http\Requests\DiscussionSearch  $request
     * @return \Illuminate\Http\Response
     */
    public function search(DiscussionSearch $request)
    {
        $this->authorize('viewAny', Discussion::class);
        $search = $request->validated();
        $discussions = Discussion::with('author', 'board', 'latest_reply')
                    ->where($search['attribute'], 'like', '%' . $search['value'] . '%')
                    ->paginate(config('rancor.pagination'));

        return DiscussionResource::collection($discussions);
    }
}