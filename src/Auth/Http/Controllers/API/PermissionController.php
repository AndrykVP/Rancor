<?php

namespace Rancor\Auth\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rancor\Auth\Models\Permission;
use Rancor\Auth\Http\Resources\PermissionResource;
use Rancor\Auth\Http\Requests\PermissionForm;
use Rancor\Auth\Http\Requests\PermissionSearch;

class PermissionController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Permission::class);

        $query = Permission::paginate(config('rancor.pagination'));

        return PermissionResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionForm $request)
    {
        $this->authorize('create',Permission::class);
        
        $data = $request->validated();
        $permission = Permission::create($data);

        return response()->json([
            'message' => 'Permission "'.$permission->name.'" has been created',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Rancor\Auth\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        $this->authorize('view',Permission::class);
        $permission->load('users','roles');

        return new PermissionResource($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Rancor\Auth\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionForm $request, Permission $permission)
    {
        $this->authorize('update', Permission::class);
        
        $data = $request->validated();
        $permission->update($data);

        return response()->json([
            'message' => 'Permission "'.$permission->name.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Rancor\Auth\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $this->authorize('delete',$permission);
        
        $permission->delete();

        return response()->json([
            'message' => 'Permission "'.$permission->name.'" has been deleted'
        ], 200);        
    }

    /**
     * Display the results that match the search query.
     *
     * @param  \Rancor\Auth\Http\Requests\PermissionSearch  $request
     * @return \Illuminate\Http\Response
     */
    public function search(PermissionSearch $request)
    {
        $this->authorize('viewAny',Permission::class);
        $search = $request->validated();
        $permissions = Permission::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                    ->paginate(config('rancor.pagination'));

        return PermissionResource::collection($permissions);
    }
}
