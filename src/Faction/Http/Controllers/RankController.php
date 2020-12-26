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
        $query = Rank::with('department.faction')->get();

        return RankResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Faction\Http\Requests\RankForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RankForm $request)
    {
        $this->authorize('create',Rank::class);
        
        $data = $request->validated();
        $rank = Rank::create($data);

        return response()->json([
            'message' => 'Rank "'.$rank->name.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Rank $rank)
    {
        $this->authorize('view', $rank);

        return new RankResource($rank->load('department.faction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Faction\Http\Requests\RankForm  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RankForm $request, Rank $rank)
    {
        $this->authorize('update',$rank);
        
        $data = $request->validated();
        $rank->update($data);

        return response()->json([
            'message' => 'Rank "'.$rank->name.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rank $rank)
    {
        $this->authorize('delete', $rank);
        
        $rank->delete();

        return response()->json([
            'message' => 'Rank "'.$rank->name.'" has been deleted'
        ], 200);        
    }
}