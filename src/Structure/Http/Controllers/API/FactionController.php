<?php

namespace Rancor\Structure\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rancor\Structure\Models\Faction;
use Rancor\Structure\Http\Resources\FactionResource;
use Rancor\Structure\Http\Requests\FactionForm;
use Rancor\Structure\Http\Requests\FactionSearch;

class FactionController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Faction::paginate(config('rancor.pagination'));

        return FactionResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Rancor\Structure\Http\Requests\FactionForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FactionForm $request)
    {
        $this->authorize('create',Faction::class);
        
        $data = $request->validated();
        $faction = Faction::create($data);

        return response()->json([
            'message' => 'Faction "'.$faction->name.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Rancor\Structure\Models\Faction  $faction
     * @return \Illuminate\Http\Response
     */
    public function show(Faction $faction)
    {
        $this->authorize('view', $faction);
        $faction->load('departments','ranks');

        return new FactionResource($faction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Rancor\Structure\Http\Requests\FactionForm  $request
     * @param  \Rancor\Structure\Models\Faction  $faction
     * @return \Illuminate\Http\Response
     */
    public function update(FactionForm $request, Faction $faction)
    {
        $this->authorize('update', $faction);
        
        $data = $request->validated();
        $faction->update($data);

        return response()->json([
            'message' => 'Faction "'.$faction->name.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Rancor\Structure\Models\Faction  $faction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faction $faction)
    {
        $this->authorize('delete', $faction);
        
        $faction->delete();

        return response()->json([
            'message' => 'Faction "'.$faction->name.'" has been deleted'
        ], 200);        
    }

    /**
     * Display the results that match the search query.
     *
     * @param  \Rancor\Structure\Http\Requests\FactionSearch  $request
     * @return \Illuminate\Http\Response
     */
    public function search(FactionSearch $request)
    {
        $this->authorize('viewAny',Faction::class);
        $search = $request->validated();
        $factions = Faction::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                    ->paginate(config('rancor.pagination'));

        return FactionResource::collection($factions);
    }
}