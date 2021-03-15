<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Models\Category;
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
        $this->middleware(config('rancor.middleware.api'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(20);

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
        
        $data = $request->validated();
        $category = Category::create([
            'body' => $data['body'],
            'discussion_id' => $data['discussion_id'],
            'author_id' => $data['user_id'],
        ]);

        return response()->json([
            'message' => 'Category has been posted'
        ], 200);
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

        return new CategoryResource($category->load('author','discussion','editor'));
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
        $category->update([
            'body' => $data['body'],
            'discussion_id' => $data['discussion_id'],
            'editor_id' => $data['user_id'],
        ]);

        return response()->json([
            'message' => 'Category #'.$category->id.' has been updated'
        ], 200);
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
        
        $category->delete();

        return response()->json([
            'message' => 'Category #'.$category->id.' has been deleted'
        ], 200);        
    }
}