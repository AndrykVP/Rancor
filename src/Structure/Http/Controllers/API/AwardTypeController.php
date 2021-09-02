<?php

namespace AndrykVP\Rancor\Structure\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Structure\Models\AwardType;
use AndrykVP\Rancor\Structure\Http\Resources\AwardTypeResource;
use AndrykVP\Rancor\Structure\Http\Requests\AwardTypeForm;

class AwardTypeController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $awardtypes = AwardType::paginate(config('rancor.pagination'));

        return AwardTypeResource::collection($awardtypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Http\Requests\AwardTypeForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AwardTypeForm $request)
    {
        $this->authorize('create',AwardType::class);
        
        $data = $request->validated();
        $awardtype = AwardType::create($data);

        return response()->json([
            'message' => 'Award Type "'.$awardtype->name.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AwardType $awardtype)
    {
        $this->authorize('view', $awardtype);
        $awardtype->load('awards');

        return new AwardTypeResource($awardtype);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Http\Requests\AwardTypeForm  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AwardTypeForm $request, AwardType $awardtype)
    {
        $this->authorize('update',$awardtype);
        
        $data = $request->validated();
        $awardtype->update($data);

        return response()->json([
            'message' => 'Award Type "'.$awardtype->name.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AwardType $awardtype)
    {
        $this->authorize('delete', $awardtype);
        $awardtype->delete();

        return response()->json([
            'message' => 'Award Type "'.$awardtype->name.'" has been deleted'
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
        $this->authorize('viewAny',AwardType::class);
        $awardtypes = AwardType::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return AwardTypeResource::collection($awardtypes);
    }
}