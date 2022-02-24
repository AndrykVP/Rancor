<?php

namespace Rancor\News\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Rancor\News\Models\Article;
use Rancor\News\Http\Resources\ArticleResource;
use Rancor\News\Http\Requests\ArticleForm;
use Rancor\News\Http\Requests\ArticleSearch;

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
		$articles = Article::paginate(config('rancor.pagination'));

		return ArticleResource::collection($articles);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Rancor\News\Http\Requests\ArticleForm  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(ArticleForm $request)
	{
		$this->authorize('create',Article::class);
		$data = $request->validated();
		$article;
		DB::transaction(function () use(&$article, $data) {
			$article = Article::create($data);
			if(array_key_exists('tags', $data))
			{
				$article->tags()->sync($data['tags']);
			}
		});

		return response()->json([
			'message' => 'Article "'.$article->name.'" has been created'
		], 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \Rancor\News\Models\Article  $article
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
	 * @param  \Rancor\News\Http\Requests\ArticleForm  $request
	 * @param  \Rancor\News\Models\Article  $article
	 * @return \Illuminate\Http\Response
	 */
	public function update(ArticleForm $request, Article $article)
	{
		$this->authorize('update', $article);
		$data = $request->validated();
		DB::transaction(function () use(&$article, $data) {
			$article->update($data);
			if(array_key_exists('tags', $data))
			{
				$article->tags()->sync($data['tags']);
			}
		});

		return response()->json([
			'message' => 'Article "'.$article->name.'" has been updated'
		], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Rancor\News\Models\Article  $article
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
	 * @param  \Rancor\News\Http\Requests\ArticleSearch  $request
	 * @return \Illuminate\Http\Response
	 */
	public function search(ArticleSearch $request)
	{
		$this->authorize('viewAny',Article::class);
		$search = $request->validated();
		$articles = Article::where($search['attribute'], 'like', '%' . $search['value'] . '%')
						->paginate(config('rancor.pagination'));

		return ArticleResource::collection($articles);
	}
}