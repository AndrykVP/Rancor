<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Auth\Role;
use AndrykVP\Rancor\Auth\Http\Resources\RoleResource;
use AndrykVP\Rancor\Auth\Http\Requests\RoleForm;

class RoleController extends Controller
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
        $this->authorize('view',Role::class);

        $query = Role::paginate(15);

        return RoleResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleForm $request)
    {
        $this->authorize('create',Role::class);
        
        $data = $request->all();
        $query = Role::create($data);

        return response()->json([
            'message' => 'Role "'.$query->name.'" has been created'
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
        $this->authorize('view',Role::class);
        
        $query = Role::findOrFail($id);

        return new RoleResource($query);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleForm $request, $id)
    {
        $this->authorize('edit',Role::class);
        
        $data = $request->all();
        $query = Role::findOrFail($id);
        $query->update($data);

        return response()->json([
            'message' => 'Role "'.$query->name.'" has been updated'
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
        $this->authorize('delete',Role::class);
        
        $query = Role::findOrFail($id);
        $query->delete();

        return response()->json([
            'message' => 'Role "'.$query->name.'" has been deleted'
        ], 200);        
    }
}
