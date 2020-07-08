<?php

namespace AndrykVP\Rancor\Faction\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Faction\Rank;
use AndrykVP\Rancor\Faction\Http\Resources\RankResource;
use AndrykVP\Rancor\Faction\Http\Requests\RankForm;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Rank::paginate(15);

        return RankResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RankForm $request)
    {
        $data = $request->all();
        $query = Rank::create($data);

        return response()->json([
            'message' => 'Rank "'.$query->name.'" has been created'
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
        $query = Rank::findOrFail($id);

        return new RankResource($query);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RankForm $request, $id)
    {
        $data = $request->all();
        $query = Rank::findOrFail($id);
        $query->update($data);

        return response()->json([
            'message' => 'Rank "'.$query->name.'" has been updated'
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
        $query = Rank::findOrFail($id);
        $query->delete();

        return response()->json([
            'message' => 'Rank "'.$query->name.'" has been deleted'
        ], 200);        
    }
}