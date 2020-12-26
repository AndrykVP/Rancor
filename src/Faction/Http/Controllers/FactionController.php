<?php

namespace AndrykVP\Rancor\Faction\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Faction\Faction;
use AndrykVP\Rancor\Faction\Http\Resources\FactionResource;
use AndrykVP\Rancor\Faction\Http\Requests\FactionForm;

class FactionController extends Controller
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
        $query = Faction::all();

        return FactionResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Faction\Http\Requests\FactionForm  $request
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
     * @param  \AndrykVP\Rancor\Faction\Faction  $faction
     * @return \Illuminate\Http\Response
     */
    public function show(Faction $faction)
    {
        $this->authorize('view', $faction);

        return new FactionResource($faction->load('departments','ranks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Faction\Http\Requests\FactionForm  $request
     * @param  \AndrykVP\Rancor\Faction\Faction  $faction
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
     * @param  \AndrykVP\Rancor\Faction\Faction  $faction
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
}