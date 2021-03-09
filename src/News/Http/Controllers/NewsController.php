<?php

namespace AndrykVP\Rancor\News\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\News\Models\Article;
use AndrykVP\Rancor\News\Models\Tag;

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
      $tags = Tag::orderBy('name')->get();

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
      $tags = Tag::orderBy('name')->get();

      return view('rancor::news.index', compact('articles','tags'));
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
      $tags = Tag::orderBy('name')->get();

      return view('rancor::news.index', compact('articles','tags'));
   }

   /**
    * Displays all published articles
    *
    * @param \AndrykVP\Rancor\News\Article  $article
    * @return \Illuminate\Http\Response
    */
   public function show(Article $article)
   {
      $this->authorize('view', $article);

      $article->load('author','editor','tags');
      $tags = Tag::orderBy('name')->get();

      return view('rancor::news.show', compact('article','tags'));
   }
}