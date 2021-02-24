<?php

namespace AndrykVP\Rancor\News\Http\Controllers;

use AndrykVP\Rancor\News\Article;
use AndrykVP\Rancor\News\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}