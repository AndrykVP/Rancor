<?php

namespace AndrykVP\Rancor\Holocron\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Holocron\Models\Collection;
use AndrykVP\Rancor\Holocron\Http\Requests\CollectionForm;

class CollectionController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Collection',
        'route' => 'collections'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Collection::class);

        $resource = $this->resource;
        $models = Collection::paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Collection::class);

        $resource = $this->resource;
        $form = array_merge(['method' => 'POST',],$this->form());
        return view('rancor::resources.create', compact('resource','form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Holocron\Http\Requests\CollectionForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollectionForm $request)
    {
        $this->authorize('create', Collection::class);

        $data = $request->validated();
        $collection = Collection::create($data);

        return redirect(route('admin.collections.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $collection->name,'action' => 'created']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Holocron\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection)
    {
        $this->authorize('view', $collection);

        $collection->loadCount('nodes');

        return view('rancor::show.collection', compact('collection'));
    }

    /**
     * Display the resources that match the search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny', Collection::class);
        
        $resource = $this->resource;
        $models = Collection::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Holocron\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        $this->authorize('update', $collection);

        $resource = $this->resource;
        $form = array_merge(['method' => 'PATCH',],$this->form());
        $model = $collection;
        return view('rancor::resources.edit', compact('resource','form','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Holocron\Http\Requests\CollectionForm  $request
     * @param  \AndrykVP\Rancor\Holocron\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(CollectionForm $request, Collection $collection)
    {
        $this->authorize('update', $collection);

        $data = $request->validated();
        $collection->update($data);

        return redirect(route('admin.collections.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $collection->name,'action' => 'updated']
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Holocron\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        $this->authorize('delete', $collection);
        
        $collection->delete();

        return redirect(route('admin.collections.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $collection->name,'action' => 'deleted'],
        ]);
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
                    'name' => 'slug',
                    'label' => 'URL',
                    'type' => 'text',
                    'attributes' => 'required'
                ],
            ],
            'textareas' => [
                [
                    'name' => 'description',
                    'label' => 'Description',
                    'type' => 'text',
                    'attributes' => 'row="4"'
                ],
            ],
        ];
    }
}
