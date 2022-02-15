<?php

namespace Rancor\Forums\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Rancor\Forums\Models\Category;
use Rancor\Forums\Http\Resources\CategoryResource;
use Rancor\Forums\Http\Requests\CategoryForm;
use Rancor\Forums\Http\Requests\CategorySearch;

class CategoryController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(config('rancor.config'));

        return CategoryResource::collection($categories);
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

        return response()->json([
            'message' => 'Category "'.$category->name.'" has been created'
        ], 200);
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

        return new CategoryResource($category->load('boards'));
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

        return response()->json([
            'message' => 'Category "'.$category->name.'" has been updated'
        ], 200);
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
        
        return response()->json([
            'message' => 'Category "'.$category->name.'" has been deleted'
        ], 200);        
    }

    /**
     * Display the results that match the search query.
     *
     * @param  \Rancor\Forums\Http\Requests\CategorySearch  $request
     * @return \Illuminate\Http\Response
     */
    public function search(CategorySearch $request)
    {
        $this->authorize('viewAny', Category::class);
        $search = $request->validated();
        $categories = Category::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                    ->paginate(config('rancor.pagination'));

        return CategoryResource::collection($categories);
    }
}