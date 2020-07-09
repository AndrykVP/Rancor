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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Article::paginate(15);

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
        $data = $request->all();
        $query = Article::create($data);

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
        $data = $request->all();
        $query = Article::findOrFail($id);
        $query->update($data);

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
        $query = Article::findOrFail($id);
        $query->delete();

        return response()->json([
            'message' => 'Article "'.$query->title.'" has been deleted'
        ], 200);        
    }
}