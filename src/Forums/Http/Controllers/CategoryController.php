<?php

namespace Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rancor\Forums\Models\Category;
use Rancor\Forums\Http\Requests\CategoryForm;
use Rancor\Forums\Http\Requests\CategorySearch;
use Auth;

class CategoryController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Category',
        'route' => 'categories'
    ];
    
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Category::class);

        $resource = $this->resource;
        $models = Category::paginate(config('rancor.pagination'));
        
        return view('rancor::resources.index',compact('models','resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Category::class);

        $resource = $this->resource;
        $form = $this->form();

        return view('rancor::resources.create', compact('resource','form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Rancor\Forums\Http\Requests\CategoryForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryForm $request)
    {
        $this->authorize('create',Category::class);
        $category = Category::create($request->validated());

        return redirect()->route('admin.categories.index')->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $category->name, 'action' => 'created']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Rancor\Forums\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $this->authorize('view',$category);
  
        $category->loadCount('boards','discussions');
  
        return view('rancor::show.category', compact('category'));
    }

    /**
     * Display the resources that match the search query.
     *
     * @param  \Rancor\Forums\Http\Requests\CategorySearch  $request
     * @return \Illuminate\Http\Response
     */
    public function search(CategorySearch $request)
    {
        $this->authorize('viewAny', Category::class);
        $resource = $this->resource;
        $search = $request->validated();
        $models = Category::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                    ->paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Rancor\Forums\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Request $request)
    {
        $this->authorize('update', $category);

        $resource = $this->resource;
        $form = $this->form();
        $model = $category;

        return view('rancor::resources.edit', compact('resource','form','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Rancor\Forums\Http\Requests\CategoryForm  $request
     * @param  \Rancor\Forums\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryForm $request, Category $category)
    {
        $this->authorize('update',$category);
        $category->update($request->validated());

        return redirect()->route('admin.categories.index')->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $category->name, 'action' => 'updated']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Rancor\Forums\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete',$category);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $category->name,'action' => 'deleted']
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
                [
                    'name' => 'color',
                    'label' => 'Color',
                    'type' => 'color',
                    'attributes' => 'required'
                ],
                [
                    'name' => 'lineup',
                    'label' => 'Display Order',
                    'type' => 'number',
                    'attributes' => 'required min="1"'
                ],
            ],
            'textareas' => [
                [
                    'name' => 'description',
                    'label' => 'Description',
                ],
            ],
        ];
    }
}