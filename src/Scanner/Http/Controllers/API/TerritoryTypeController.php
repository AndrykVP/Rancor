<?php

namespace Rancor\Scanner\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rancor\Scanner\Models\TerritoryType;
use Rancor\Scanner\Http\Requests\TerritoryTypeForm;
use Rancor\Scanner\Http\Requests\TerritoryTypeSearch;
use Rancor\Scanner\Http\Resources\TerritoryTypeResource;

class TerritoryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',TerritoryType::class);
        $terrytorytypes = TerritoryType::paginate(config('rancor.pagination'));

        return TerritoryTypeResource::collection($terrytorytypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Rancor\Scanner\Http\Requests\TerritoryType  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TerritoryTypeForm $request)
    {
        $this->authorize('create',TerritoryType::class);
        $territorytype = TerritoryType::create($request->validated());

        return response()->json([
            'message' => "Territory Type \"{$territorytype->name}\" has been created",
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Rancor\Scanner\Models\TerritoryType  $territorytype
     * @return \Illuminate\Http\Response
     */
    public function show(TerritoryType $territorytype)
    {
        $this->authorize('view', $territorytype);

        return new TerritoryTypeResource($territorytype);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Rancor\Scanner\Http\Requests\TerritoryTypeForm  $request
     * @param  \Rancor\Scanner\Models\TerritoryType  $territorytype
     * @return \Illuminate\Http\Response
     */
    public function update(TerritoryTypeForm $request, TerritoryType $territorytype)
    {
        $this->authorize('update', $territorytype);
        $territorytype->update($request->validated());
        
        return response()->json([
            'message' => "Territory Type \"{$territorytype->name}\" has been updated",
        ],200);
    }

    /**
     * Remove the specified Usergroup resource from storage.
     *
     * @param  \Rancor\Scanner\Models\TerritoryType  $territorytype
     * @return \Illuminate\Http\Response
     */
    public function destroy(TerritoryType $territorytype)
    {
        $this->authorize('delete', $territorytype);
        $territorytype->delete();

        return response()->json([
            'message' => "Territory Type \"{$territorytype->name}\" has been deleted",
        ],200);
    }

    /**
     * Search specified resource.
     *
     * @param  \Rancor\Scanner\Http\Requests\TerritoryTypeSearch  $request
     * @return \Illuminate\Http\Response
     */
    public function search(TerritoryTypeSearch $request)
    {
        $this->authorize('viewAny', TerritoryType::class);
        $search = $request->validated();
        $territorytypes = TerritoryType::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                        ->paginate(config('rancor.pagination'));
        
        return TerritoryTypeResource::collection($territorytypes);
    }
}
