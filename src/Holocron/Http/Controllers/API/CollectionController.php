<?php

namespace AndrykVP\Rancor\Holocron\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Holocron\Models\Collection;
use AndrykVP\Rancor\Holocron\Http\Resources\CollectionResource;
use AndrykVP\Rancor\Holocron\Http\Requests\CollectionForm;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Collection::class);
        $collections = Collection::paginate(config('rancor.pagination'));

        return CollectionResource::collection($collections);
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

        return response()->json([
            'message' => 'Collection "'.$collection->name.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Holocron\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection)
    {
        $this->authorize('view',$collection);
        $collection->load('nodes');

        return new CollectionResource($collection);
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

        return response()->json([
            'message' => 'Collection "'.$collection->name.'" has been updated'
        ], 200);
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

        return response()->json([
            'message' => 'Collection "'.$collection->name.'" has been deleted'
        ], 200);
    }

    /**
     * Display the results that match the search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny',Collection::class);
        
        $collections = Collection::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return CollectionResource::collection($collections);
    }
}
