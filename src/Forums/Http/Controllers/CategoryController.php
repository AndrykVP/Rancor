<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Models\Category;
use AndrykVP\Rancor\Forums\Models\Group;
use AndrykVP\Rancor\Forums\Http\Requests\CategoryForm;
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
        $form = array_merge(['method' => 'POST'],$this->form());

        return view('rancor::resources.create', compact('resource','form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\CategoryForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryForm $request)
    {
        $this->authorize('create',Category::class);
        
        $data = $request->validated();
        $category;
        DB::transaction(function () use(&$category, $data) {
            $category = Category::create($data);
            $category->groups()->sync($data['groups']);
        });

        return redirect()->route('admin.categories.index')->with('alert', ['model' => $resource->name, 'name' => $category->name, 'action' => 'created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $this->authorize('view',$category);
  
        $category->loadCount('boards','discussions')->load('groups');
  
        return view('rancor::show.category', compact('category'));
    }

    /**
     * Display the resources that match the search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny', Category::class);
        
        $resource = $this->resource;
        $models = Category::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Request $request)
    {
        $this->authorize('update', $category);

        $resource = $this->resource;
        $form = array_merge(['method' => 'POST'],$this->form());
        $model = $category;

        return view('rancor::resources.edit', compact('resource','form','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\CategoryForm  $request
     * @param  \AndrykVP\Rancor\Forums\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryForm $request, Category $category)
    {
        $this->authorize('update',$category);
        
        $data = $request->validated();
        DB::transaction(function () use(&$category, $data) {
            $category->update($data);
            $category->groups()->sync($data['groups']);
        });

        return redirect()->route('admin.categories.index')->with('alert', ['model' => $resource->name, 'name' => $category->name, 'action' => 'updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete',$category);
        
        DB::transaction(function () use($category) {
            $category->groups()->detach();
            $category->delete();
        });

        return redirect()->route('admin.categories.index')->with('alert', ['model' => $resource->name, 'name' => $category->name,'action' => 'deleted']);
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
                    'name' => 'order',
                    'label' => 'Display Order',
                    'type' => 'number',
                    'attributes' => 'required'
                ],
            ],
            'selects' => [
                [
                    'name' => 'groups',
                    'label' => 'Groups',
                    'attributes' => 'multiple',
                    'multiple' => true,
                    'options' => Group::orderBy('name')->get(),
                ]
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