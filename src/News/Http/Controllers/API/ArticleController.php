<?php

namespace AndrykVP\Rancor\News\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\News\Models\Article;
use AndrykVP\Rancor\News\Http\Resources\ArticleResource;
use AndrykVP\Rancor\News\Http\Requests\EditArticleForm;
use AndrykVP\Rancor\News\Http\Requests\NewArticleForm;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Article::class);
        $articles = Article::with('tags')->paginate(config('rancor.pagination'));

        return ArticleResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\News\Http\Requests\NewArticleForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewArticleForm $request)
    {
        $this->authorize('create',Article::class);
        $data = $request->validated();
        $article;
        DB::transaction(function () use(&$article, $data) {
            $article = Article::create($data);
            $article->tags()->sync($data['tags']);
        });

        return response()->json([
            'message' => 'Article "'.$article->name.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\News\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $this->authorize('view', $article);
        $article->load('tags','author','editor');

        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\News\Http\Requests\EditArticleForm  $request
     * @param  \AndrykVP\Rancor\News\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(EditArticleForm $request, Article $article)
    {
        $this->authorize('update', $article);
        $data = $request->validated();
        DB::transaction(function () use(&$article, $data) {
            $article->update($data);
            $article->tags()->sync($data['tags']);
        });

        return response()->json([
            'message' => 'Article "'.$article->name.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\News\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();

        return response()->json([
            'message' => 'Article "'.$article->name.'" has been deleted'
        ], 200);        
    }

    /**
     * Display the results that match the search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny',Article::class);
        
        $articles = Article::with('tags')->where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return ArticleResource::collection($articles);
    }
}