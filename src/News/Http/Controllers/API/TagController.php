<?php

namespace AndrykVP\Rancor\News\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\News\Tag;
use AndrykVP\Rancor\News\Http\Resources\TagResource;
use AndrykVP\Rancor\News\Http\Requests\TagForm;

class TagController extends Controller
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
        $this->authorize('viewAny',Tag::class);

        $query = Tag::latest()->paginate(10);

        return TagResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagForm $request)
    {
        $this->authorize('create',Tag::class);
        
        $data = $request->validated();
        $tag = Tag::create($data);

        return response()->json([
            'message' => 'Tag "'.$tag->name.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $this->authorize('view', $tag);

        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagForm $request, Tag $tag)
    {
        $this->authorize('update', $tag);
        
        $data = $request->validated();
        $tag->update($data);

        return response()->json([
            'message' => 'Tag "'.$tag->title.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);

        $tag->delete();

        return response()->json([
            'message' => 'Tag "'.$tag->title.'" has been deleted'
        ], 200);        
    }
}