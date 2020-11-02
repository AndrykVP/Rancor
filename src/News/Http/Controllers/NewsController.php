<?php

namespace AndrykVP\Rancor\News\Http\Controllers;

use App\Http\Controllers\Controller;
use AndrykVP\Rancor\News\Article;
use AndrykVP\Rancor\News\Http\Resources\ArticleResource;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Article::where('is_published',true)->latest()->paginate(10);

        return ArticleResource::collection($query);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = Article::findOrFail($id);

        if($query->is_published)
        {
            return new ArticleResource($query);
        }

        return response()->json([
            'message' => 'This news article is unpublished'
        ], 200);
    }
}