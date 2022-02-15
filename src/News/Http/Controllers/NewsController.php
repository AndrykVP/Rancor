<?php

namespace Rancor\News\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rancor\News\Models\Article;
use Rancor\News\Models\Tag;

class NewsController extends Controller
{
   /**
    * Construct controller
    *
    * @return void
    */
   public function __construct()
   {
      $this->middleware('auth')->only('drafts');
   }

   /**
    * Displays all published articles
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $articles = Article::published()
                  ->with('author','editor','tags')
                  ->latest()
                  ->paginate(config('rancor.pagination'));
      $tags = Tag::orderBy('name')->withCount('articles')->get();

      return view('rancor::news.index', compact('articles','tags'));
   }

   /**
    * Displays all unpublished articles
    *
    * @return \Illuminate\Http\Response
    */
   public function drafts()
   {
      $this->authorize('viewAny', Article::class);

      $articles = Article::published(false)
                  ->with('author','editor','tags')
                  ->latest()
                  ->paginate(config('rancor.pagination'));
      $tags = Tag::orderBy('name')->withCount('articles')->get();

      return view('rancor::news.drafts', compact('articles','tags'));
   }

   /**
    * Displays all published articles under a specific tag
    *
    * @return \Illuminate\Http\Response
    */
   public function tagged(Tag $tag)
   {
      $articles = $tag->articles()
                  ->published()
                  ->with('author','editor','tags')
                  ->latest()
                  ->paginate(config('rancor.pagination'));
      $tags = Tag::orderBy('name')->withCount('articles')->get();

      return view('rancor::news.tagged', compact('articles','tags','tag'));
   }

   /**
    * Displays all published articles
    *
    * @param \Rancor\News\Models\Article  $article
    * @return \Illuminate\Http\Response
    */
   public function show(Article $article)
   {
      $this->authorize('view', $article);

      $article->load('author','editor','tags');
      $tags = Tag::orderBy('name')->withCount('articles')->get();

      return view('rancor::news.show', compact('article','tags'));
   }
}