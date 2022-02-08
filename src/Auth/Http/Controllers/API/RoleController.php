<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Auth\Models\Role;
use AndrykVP\Rancor\Auth\Http\Resources\RoleResource;
use AndrykVP\Rancor\Auth\Http\Requests\RoleForm;
use AndrykVP\Rancor\Auth\Http\Requests\RoleSearch;

class RoleController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny',Role::class);

        $query = Role::paginate(config('rancor.pagination'));

        return RoleResource::collection($query);
    }

    public function store(RoleForm $request): JsonResponse
    {
        $this->authorize('create',Role::class);
        
        $data = $request->validated();
        $role = null;
        DB::transaction(function () use(&$role, $data) {
            $role = Role::create($data);
            $role->permissions()->sync($data['permissions']);
        });

        return response()->json([
            'message' => 'Role "'.$role->name.'" has been created'
        ], 200);
    }

    public function show(Role $role): RoleResource
    {
        $this->authorize('view',Role::class);
        $role->load('users','permissions');

        return new RoleResource($role);
    }

    public function update(RoleForm $request, Role $role): JsonResponse
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

    public function destroy(Role $role): JsonResponse
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

    public function search(RoleSearch $request): AnonymousResourceCollection
    {
        $this->authorize('viewAny',Role::class);
        $search = $request->validated();
        $roles = Role::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                ->paginate(config('rancor.pagination'));

        return RoleResource::collection($roles);
    }
}
