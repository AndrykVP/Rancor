<?php

namespace AndrykVP\Rancor\News\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\News\Models\Article;
use AndrykVP\Rancor\News\Models\Tag;
use AndrykVP\Rancor\News\Http\Requests\NewArticleForm;
use AndrykVP\Rancor\News\Http\Requests\EditArticleForm;

class ArticleController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Article',
        'route' => 'articles'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Article::class);

        $resource = $this->resource;
        $models = Article::paginate(config('rancor.pagination'));

        return view('rancor::resources.index',compact('models','resource'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Article::class);

        $resource = $this->resource;
        $form = array_merge($this->form(),['method' => 'POST']);

        return view('rancor::resources.create', compact('form','resource'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\News\Http\Requests\NewArticleForm  $request
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

        return redirect(route('admin.articles.index'))->with('alert',['model' => $resource->name, 'name' => $article->name,'action' => 'created']);
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

        return view('rancor::show.article',compact('article'));
    }

    /**
     * Display the resources that match the search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny', Article::class);
        
        $resource = $this->resource;
        $models = Article::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
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

        $resource = $this->resource;
        $form = array_merge($this->form(),['method' => 'PATCH']);
        $model = $article;

        return view('rancor::resources.edit',compact('resource', 'form','model'));
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

        return redirect(route('admin.articles.index'))->with('alert',['model' => $resource->name, 'name' => $article->name,'action' => 'updated']);
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
         
        return redirect(route('articles.index'))->with('alert',['model' => $resource->name, 'name' => $article->name,'action' => 'deleted']);
    }

    /**
     * Variable for Form fields used in Create and Edit Views
     * 
     * @var array
     */
    protected function form()
    {
        return [
            'inputs' => [
                [
                    'name' => 'name',
                    'label' => 'Title',
                    'type' => 'text',
                    'attributes' => 'autofocus required'
                ],
            ],
            'textareas' => [
                [
                    'name' => 'body',
                    'label' => 'Content',
                    'type' => 'text',
                    'attributes' => 'row="7"'
                ],
                [
                    'name' => 'description',
                    'label' => 'Short Description',
                    'type' => 'text',
                    'attributes' => 'row="4"'
                ],
            ],
            'selects' => [
                [
                    'name' => 'tags',
                    'label' => 'tags',
                    'attributes' => 'multiple',
                    'multiple' => true,
                    'options' => Tag::orderBy('name')->get(),
                ],
            ],
            'checkboxes' => [
                [
                    'name' => 'is_published',
                    'label' => 'Publish?',
                ]
            ]
        ];
    }
}
