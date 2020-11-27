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
        $this->authorize('viewAny',Article::class);

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
        $this->authorize('viewAny',Article::class);

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
        
        $data = $request->validated();
        $article = new Article;
        $article->fill($data);
        $article->author_id = $request->user()->id;
        $article->save();

        return response()->json([
            'message' => 'Article "'.$article->title.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $this->authorize('view', $article);

        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleForm $request, Article $article)
    {
        $this->authorize('update', $article);
        
        $data = $request->validated();
        $article->fill($data);
        $article->editor_id = $request->user()->id;
        $article->save();

        return response()->json([
            'message' => 'Article "'.$article->title.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();

        return response()->json([
            'message' => 'Article "'.$article->title.'" has been deleted'
        ], 200);        
    }
}