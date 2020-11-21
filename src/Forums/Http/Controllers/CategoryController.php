<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Category;
use AndrykVP\Rancor\Forums\Http\Resources\CategoryResource;
use AndrykVP\Rancor\Forums\Http\Requests\CategoryForm;

class CategoryController extends Controller
{
    /**
     * Construct Controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware(config('rancor.middleware'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
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
        
        $data = $request->all();
        $category = Category::create($data);

        return response()->json([
            'message' => 'Category "'.$category->title.'" has been created'
        ], 200);
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

        return new CategoryResource($category->load('groups','boards'));
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
        
        $data = $request->all();
        $category->update($data);

        return response()->json([
            'message' => 'Category "'.$category->title.'" has been updated'
        ], 200);
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

        return response()->json([
            'message' => 'Category "'.$category->name.'" has been deleted'
        ], 200);        
    }
}