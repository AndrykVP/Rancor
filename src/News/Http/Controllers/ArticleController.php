<?php

namespace AndrykVP\Rancor\News\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\News\Article;
use AndrykVP\Rancor\News\Http\Resources\ArticleResource;
use AndrykVP\Rancor\News\Http\Requests\ArticleForm;

class ArticleController extends Controller
{
    /**
     * Construct Controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware(config('rancor.middleware'))->except('public');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view',Article::class);

        $query = Article::latest()->paginate(10);

        return ArticleResource::collection($query);
    }
    
    /**
     * Display a listing of published resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function public()
    {
        $query = Article::where('is_published',true)->latest()->paginate(10);

        return ArticleResource::collection($query);
    }

    /**
     * Display a listing of drafted resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function drafts()
    {
        $this->authorize('view',Article::class);

        $query = Article::where('is_published',false)->latest()->paginate(10);

        return ArticleResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleForm $request)
    {
        $this->authorize('create',Article::class);
        
        $data = $request->all();

        $query = new Article;
        $query->title = $data['title'];
        $query->content = $data['content'];
        $query->is_published = $data['is_published'];
        $query->author_id = $request->user()->id;
        $query->save();

        return response()->json([
            'message' => 'Article "'.$query->title.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view',Article::class);
        
        $query = Article::findOrFail($id);

        return new ArticleResource($query);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleForm $request, $id)
    {
        $this->authorize('update',Article::class);
        
        $data = $request->all();
        $query = Article::findOrFail($id);
        $query->title = $data['title'];
        $query->content = $data['content'];
        $query->is_published = $data['is_published'];
        $query->editor_id = $request->user()->id;
        $query->save();

        return response()->json([
            'message' => 'Article "'.$query->title.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete',Article::class);
        
        $query = Article::findOrFail($id);
        $query->delete();

        return response()->json([
            'message' => 'Article "'.$query->title.'" has been deleted'
        ], 200);        
    }
}