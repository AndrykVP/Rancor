<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Auth\Models\Permission;
use AndrykVP\Rancor\Auth\Http\Resources\PermissionResource;
use AndrykVP\Rancor\Auth\Http\Requests\PermissionForm;
use AndrykVP\Rancor\Auth\Http\Requests\PermissionSearch;

class PermissionController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny',Permission::class);

        $query = Permission::paginate(config('rancor.pagination'));

        return PermissionResource::collection($query);
    }

    public function store(PermissionForm $request): JsonResponse
    {
        $this->authorize('create',Permission::class);
        
        $data = $request->validated();
        $permission = Permission::create($data);

        return response()->json([
            'message' => 'Permission "'.$permission->name.'" has been created',
        ], 200);
    }

    public function show(Permission $permission): PermissionResource
    {
        $this->authorize('view',Permission::class);
        $permission->load('users','roles');

        return new PermissionResource($permission);
    }

    public function update(PermissionForm $request, Permission $permission): JsonResponse
    {
        $this->authorize('update', Permission::class);
        
        $data = $request->validated();
        $permission->update($data);

        return response()->json([
            'message' => 'Permission "'.$permission->name.'" has been updated'
        ], 200);
    }

    public function destroy(Permission $permission): JsonResponse
    {
        $this->authorize('delete',$permission);
        
        $permission->delete();

        return response()->json([
            'message' => 'Permission "'.$permission->name.'" has been deleted'
        ], 200);        
    }

    public function search(PermissionSearch $request): AnonymousResourceCollection
    {
        $this->authorize('viewAny',Permission::class);
        $search = $request->validated();
        $permissions = Permission::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                    ->paginate(config('rancor.pagination'));

        return PermissionResource::collection($permissions);
    }
}
