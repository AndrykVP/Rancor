<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Auth\Models\Permission;
use AndrykVP\Rancor\Auth\Http\Resources\PermissionResource;
use AndrykVP\Rancor\Auth\Http\Requests\PermissionForm;
use AndrykVP\Rancor\Package\Http\Requests\SearchForm;

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
     * @param  \AndrykVP\Rancor\Auth\Models\Permission $permission
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
     * @param  \AndrykVP\Rancor\Auth\Models\Permission $permission
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
     * @param  \AndrykVP\Rancor\Auth\Models\Permission $permission
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
     * @param  \AndrykVP\Rancor\Package\Http\Requests\SearchForm  $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchForm $request)
    {
        $this->authorize('viewAny',Permission::class);
        $search = $request->validated();
        $permissions = Permission::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                    ->paginate(config('rancor.pagination'));

        return PermissionResource::collection($permissions);
    }
}
