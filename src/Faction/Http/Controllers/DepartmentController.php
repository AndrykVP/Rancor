<?php

namespace AndrykVP\Rancor\Faction\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Faction\Department;
use AndrykVP\Rancor\Faction\Http\Resources\DepartmentResource;
use AndrykVP\Rancor\Faction\Http\Requests\DepartmentForm;

class DepartmentController extends Controller
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
        $query = Department::all();

        return DepartmentResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentForm $request)
    {
        $this->authorize('create',Department::class);
        
        $data = $request->all();
        $query = Department::create($data);

        return response()->json([
            'message' => 'Department "'.$query->name.'" has been created'
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
        $this->authorize('view',Department::class);
        
        $query = Department::findOrFail($id);

        return new DepartmentResource($query);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentForm $request, $id)
    {
        $this->authorize('update',Department::class);
        
        $data = $request->all();
        $query = Department::findOrFail($id);
        $query->update($data);

        return response()->json([
            'message' => 'Department "'.$query->name.'" has been updated'
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
        $this->authorize('delete',Department::class);
        
        $query = Department::findOrFail($id);
        $query->delete();

        return response()->json([
            'message' => 'Department "'.$query->name.'" has been deleted'
        ], 200);        
    }
}