<?php

namespace AndrykVP\Rancor\Structure\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Structure\Models\Type;
use AndrykVP\Rancor\Structure\Http\Resources\TypeResource;
use AndrykVP\Rancor\Structure\Http\Requests\TypeForm;

class TypeController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::paginate(config('rancor.pagination'));

        return TypeResource::collection($types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Http\Requests\TypeForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeForm $request)
    {
        $this->authorize('create',Type::class);
        
        $data = $request->validated();
        $type = Type::create($data);

        return response()->json([
            'message' => 'Type "'.$type->name.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        $this->authorize('view', $type);
        $type->load('awards');

        return new TypeResource($type);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Http\Requests\TypeForm  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TypeForm $request, Type $type)
    {
        $this->authorize('update',$type);
        
        $data = $request->validated();
        $type->update($data);

        return response()->json([
            'message' => 'Type "'.$type->name.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $this->authorize('delete', $type);
        $type->delete();

        return response()->json([
            'message' => 'Type "'.$type->name.'" has been deleted'
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
        $this->authorize('viewAny',Type::class);
        $types = Type::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return TypeResource::collection($types);
    }
}