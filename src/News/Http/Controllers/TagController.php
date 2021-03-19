<?php

namespace AndrykVP\Rancor\News\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\News\Models\Tag;
use AndrykVP\Rancor\News\Http\Requests\TagForm;

class TagController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Tag',
        'route' => 'tags'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Tag::class);

        $resource = $this->resource;
        $models = Tag::paginate(config('rancor.pagination'));

        return view('rancor::resources.index',compact('models','resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Tag::class);

        $resource = $this->resource;
        $form = array_merge($this->form(),['method' => 'POST']);

        return view('rancor::resources.create', compact('resource','form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\News\Http\Requests\TagForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagForm $request)
    {
        $this->authorize('create', Tag::class);

        $data = $request->validated();
        $tag = Tag::create($data);
        
        return redirect(route('admin.tags.index'))->with('alert', ['model' => $resource->name, 'name' => $tag->name,'action' => 'created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $this->authorize('view', $tag);
        $tag->loadCount('articles');

        return view('rancor::show.tag',compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        $this->authorize('update', $tag);

        $resource = $this->resource;
        $form = array_merge($this->form(),['method' => 'PATCH']);
        $model = $tag;
        
        return view('rancor::resources.edit',compact('resource','form','tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\News\Http\Requests\TagForm  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagForm $request, Tag $tag)
    {
        $this->authorize('update', $tag);

        $data = $request->validated();
        $tag->update($data);
        
        return redirect(route('tags.index'))->with('alert', ['model' => $resource->name, 'name' => $tag->name,'action' => 'updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);
        $tag->delete();

        return redirect(route('tags.index'))->with('alert', ['model' => $resource->name, 'name' => $tag->name,'action' => 'deleted']);
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
                    'label' => 'Name',
                    'type' => 'text',
                    'attributes' => 'autofocus required'
                ],
                [
                    'name' => 'color',
                    'label' => 'Color',
                    'type' => 'color',
                ],
            ],
        ];
    }
}
