<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers\API;

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
        $this->middleware(config('rancor.middleware.api'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Role::class);

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
        
        $data = $request->validated();
        $role = Role::create($data);

        return response()->json([
            'message' => 'Role "'.$role->name.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Auth\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $this->authorize('view',Role::class);

        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \AndrykVP\Rancor\Auth\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleForm $request, Role $role)
    {
        $this->authorize('update', Role::class);
        
        $data = $request->validated();
        $role->update($data);

        return response()->json([
            'message' => 'Role "'.$role->name.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Auth\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete',$role);
        
        $role->delete();

        return response()->json([
            'message' => 'Role "'.$role->name.'" has been deleted'
        ], 200);        
    }
}
