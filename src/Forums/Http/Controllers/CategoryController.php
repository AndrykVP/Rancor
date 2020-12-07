<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Category;
use AndrykVP\Rancor\Forums\Group;
use AndrykVP\Rancor\Forums\Http\Requests\CategoryForm;
use Auth;

class CategoryController extends Controller
{
    /**
     * Construct Controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Category::class);

        $categories = Category::orderBy('order')->get();
        
        return view('rancor::categories.index',['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Category::class);

        return view('rancor::categories.create');
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
        $category = Category::create($data);

        return redirect()->route('forums.categories.index')->with('success', 'Category "'.$category->title.'" has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $this->authorize('view',$category);

        $boards = Auth::user()->topics();
  
        $category->load(['boards' => function($query) use($boards) {
           $query->whereIn('id',$boards)
                ->topTier()
                ->withCount('discussions','replies')
                ->with('latest_reply.discussion','children')
                ->orderBy('order');
        }])->loadCount('boards');
  
        return view('rancor::categories.show',['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Request $request)
    {
        $this->authorize('update', $category);
        $groups = Group::all();

        return view('rancor::categories.edit',compact('category','groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\CategoryForm  $request
     * @param  \AndrykVP\Rancor\Forums\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryForm $request, Category $category)
    {
        $this->authorize('update',$category);
        
        $data = $request->validated();
        $category->update($data);

        return redirect()->route('forums.categories.index')->with('success', 'Category "'.$category->title.'" has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete',$category);
        
        $category->delete();

        return redirect()->route('forums.categories.index')->with('success', 'Category "'.$category->title.'" has been successfully deleted');
    }
}