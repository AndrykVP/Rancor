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
        $this->middleware(config('rancor.middleware.api'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Department::with('faction')->get();

        return DepartmentResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Faction\Http\Requests\DepartmentForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentForm $request)
    {
        $this->authorize('create',Department::class);
        
        $data = $request->validated();
        $department = Department::create($data);

        return response()->json([
            'message' => 'Department "'.$department->name.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Faction\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        $this->authorize('view', $department);

        return new DepartmentResource($department->load('faction','ranks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Faction\Http\Requests\DepartmentForm  $request
     * @param  \AndrykVP\Rancor\Faction\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentForm $request, Department $department)
    {
        $this->authorize('update', $department);
        
        $data = $request->validated();
        $department->update($data);

        return response()->json([
            'message' => 'Department "'.$department->name.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Faction\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $this->authorize('delete', $department);
        
        $department->delete();

        return response()->json([
            'message' => 'Department "'.$department->name.'" has been deleted'
        ], 200);        
    }
}