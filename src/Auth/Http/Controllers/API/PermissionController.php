<?php

namespace Rancor\Auth\Http\Controllers\API;

<<<<<<< HEAD
=======
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
use App\Http\Controllers\Controller;
use Rancor\Auth\Models\Permission;
use Rancor\Auth\Http\Resources\PermissionResource;
use Rancor\Auth\Http\Requests\PermissionForm;
use Rancor\Auth\Http\Requests\PermissionSearch;

class PermissionController extends Controller
<<<<<<< HEAD
{    
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->authorize('viewAny',Permission::class);
=======
{
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny',Permission::class);
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		$query = Permission::paginate(config('rancor.pagination'));

		return PermissionResource::collection($query);
	}

<<<<<<< HEAD
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
=======
    public function store(PermissionForm $request): JsonResponse
    {
        $this->authorize('create',Permission::class);
        
        $data = $request->validated();
        $permission = Permission::create($data);
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return response()->json([
			'message' => 'Permission "'.$permission->name.'" has been created',
		], 200);
	}

<<<<<<< HEAD
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
=======
    public function show(Permission $permission): PermissionResource
    {
        $this->authorize('view',Permission::class);
        $permission->load('users','roles');
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return new PermissionResource($permission);
	}

<<<<<<< HEAD
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
=======
    public function update(PermissionForm $request, Permission $permission): JsonResponse
    {
        $this->authorize('update', Permission::class);
        
        $data = $request->validated();
        $permission->update($data);
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return response()->json([
			'message' => 'Permission "'.$permission->name.'" has been updated'
		], 200);
	}

<<<<<<< HEAD
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
=======
    public function destroy(Permission $permission): JsonResponse
    {
        $this->authorize('delete',$permission);
        
        $permission->delete();
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return response()->json([
			'message' => 'Permission "'.$permission->name.'" has been deleted'
		], 200);        
	}

<<<<<<< HEAD
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
=======
    public function search(PermissionSearch $request): AnonymousResourceCollection
    {
        $this->authorize('viewAny',Permission::class);
        $search = $request->validated();
        $permissions = Permission::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                    ->paginate(config('rancor.pagination'));
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return PermissionResource::collection($permissions);
	}
}
