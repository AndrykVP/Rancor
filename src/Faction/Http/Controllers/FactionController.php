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
        $this->middleware(config('rancor.middleware'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Faction::paginate(15);

        return FactionResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FactionForm $request)
    {
        $data = $request->all();
        $query = Faction::create($data);

        return response()->json([
            'message' => 'Faction "'.$query->name.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = Faction::findOrFail($id);

        return new FactionResource($query);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FactionForm $request, $id)
    {
        $data = $request->all();

        $query = Faction::findOrFail($id);
        $query->update($data);

        return response()->json([
            'message' => 'Faction "'.$query->name.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = Faction::findOrFail($id);
        $query->delete();

        return response()->json([
            'message' => 'Faction "'.$query->name.'" has been deleted'
        ], 200);        
    }
}