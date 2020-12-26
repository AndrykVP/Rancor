<?php

namespace AndrykVP\Rancor\News\Http\Controllers;

use AndrykVP\Rancor\News\Article;
use AndrykVP\Rancor\News\Tag;
use AndrykVP\Rancor\News\Http\Requests\NewArticleForm;
use AndrykVP\Rancor\News\Http\Requests\EditArticleForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Construct Controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with('author','editor')->paginate(config('rancor.pagination'));

        return view('rancor::articles.index',compact('articles'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Article::class);

        $tags = Tag::all();

        return view('rancor::articles.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\News\Http\Requests\ArticleForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewArticleForm $request)
    {
        $this->authorize('create', Article::class);

        $data = $request->validated();
        $article;
        DB::transaction(function () use(&$article,$data) {
            $article = Article::create($data);
            $article->tags()->sync($data['tags']);
        });

        return redirect(route('articles.index'))->with('success','Article "'.$article->title.'" has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $this->authorize('view', $article);
        $article->load('author','editor','tags');

        return view('rancor::articles.show',compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $this->authorize('update', $article);

        $tags = Tag::orderBy('name')->get();
        $article->load('tags');

        return view('rancor::articles.edit',compact('article', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\News\Http\Requests\ArticleForm  $request
     * @param  \App\Article  $article
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

        return redirect(route('articles.index'))->with('success','Article "'.$article->title.'" has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();
         
        return redirect(route('articles.index'))->with('success','Article "'.$article->title.'" has been successfully deleted');
    }
}
