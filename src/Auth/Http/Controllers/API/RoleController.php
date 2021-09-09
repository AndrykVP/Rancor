<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Auth\Models\Role;
use AndrykVP\Rancor\Auth\Http\Resources\RoleResource;
use AndrykVP\Rancor\Auth\Http\Requests\RoleForm;
use AndrykVP\Rancor\Auth\Http\Requests\RoleSearch;

class RoleController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Role::class);

        $query = Role::paginate(config('rancor.pagination'));

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
        $role;
        DB::transaction(function () use(&$role, $data) {
            $role = Role::create($data);
            $role->permissions()->sync($data['permissions']);
        });

        return response()->json([
            'message' => 'Role "'.$role->name.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Auth\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $this->authorize('view',Role::class);
        $role->load('users','permissions');

        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \AndrykVP\Rancor\Auth\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleForm $request, Role $role)
    {
        $this->authorize('update', Role::class);
        
        $data = $request->validated();
        DB::transaction(function () use(&$role, $data) {
            $role->update($data);
            $role->permissions()->sync($data['permissions']);
        });

        return response()->json([
            'message' => 'Role "'.$role->name.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Auth\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete',$role);
        
        DB::transaction(function () use($role) {
            $role->permissions()->detach();
            $role->delete();
        });

        return response()->json([
            'message' => 'Role "'.$role->name.'" has been deleted'
        ], 200);        
    }

    /**
     * Display the results that match the search query.
     *
     * @param  \AndrykVP\Rancor\Auth\Http\Requests\RoleSearch  $request
     * @return \Illuminate\Http\Response
     */
    public function search(RoleSearch $request)
    {
        $this->authorize('viewAny',Role::class);
        $search = $request->validated();
        $roles = Role::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                ->paginate(config('rancor.pagination'));

        return RoleResource::collection($roles);
    }
}
