<?php

namespace Rancor\Auth\Http\Controllers\API;

<<<<<<< HEAD
=======
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Rancor\Auth\Models\Role;
use Rancor\Auth\Http\Resources\RoleResource;
use Rancor\Auth\Http\Requests\RoleForm;
use Rancor\Auth\Http\Requests\RoleSearch;

class RoleController extends Controller
<<<<<<< HEAD
{    
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->authorize('viewAny',Role::class);
=======
{
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny',Role::class);
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		$query = Role::paginate(config('rancor.pagination'));

		return RoleResource::collection($query);
	}

<<<<<<< HEAD
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
=======
    public function store(RoleForm $request): JsonResponse
    {
        $this->authorize('create',Role::class);
        
        $data = $request->validated();
        $role = null;
        DB::transaction(function () use(&$role, $data) {
            $role = Role::create($data);
            $role->permissions()->sync($data['permissions']);
        });
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return response()->json([
			'message' => 'Role "'.$role->name.'" has been created'
		], 200);
	}

<<<<<<< HEAD
	/**
	 * Display the specified resource.
	 *
	 * @param  \Rancor\Auth\Models\Role $role
	 * @return \Illuminate\Http\Response
	 */
	public function show(Role $role)
	{
		$this->authorize('view',Role::class);
		$role->load('users','permissions');
=======
    public function show(Role $role): RoleResource
    {
        $this->authorize('view',Role::class);
        $role->load('users','permissions');
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return new RoleResource($role);
	}

<<<<<<< HEAD
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Rancor\Auth\Models\Role $role
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
=======
    public function update(RoleForm $request, Role $role): JsonResponse
    {
        $this->authorize('update', Role::class);
        
        $data = $request->validated();
        DB::transaction(function () use(&$role, $data) {
            $role->update($data);
            $role->permissions()->sync($data['permissions']);
        });
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return response()->json([
			'message' => 'Role "'.$role->name.'" has been updated'
		], 200);
	}

<<<<<<< HEAD
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Rancor\Auth\Models\Role $role
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Role $role)
	{
		$this->authorize('delete',$role);
		
		DB::transaction(function () use($role) {
			$role->permissions()->detach();
			$role->delete();
		});
=======
    public function destroy(Role $role): JsonResponse
    {
        $this->authorize('delete',$role);
        
        DB::transaction(function () use($role) {
            $role->permissions()->detach();
            $role->delete();
        });
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return response()->json([
			'message' => 'Role "'.$role->name.'" has been deleted'
		], 200);        
	}

<<<<<<< HEAD
	/**
	 * Display the results that match the search query.
	 *
	 * @param  \Rancor\Auth\Http\Requests\RoleSearch  $request
	 * @return \Illuminate\Http\Response
	 */
	public function search(RoleSearch $request)
	{
		$this->authorize('viewAny',Role::class);
		$search = $request->validated();
		$roles = Role::where($search['attribute'], 'like', '%' . $search['value'] . '%')
				->paginate(config('rancor.pagination'));
=======
    public function search(RoleSearch $request): AnonymousResourceCollection
    {
        $this->authorize('viewAny',Role::class);
        $search = $request->validated();
        $roles = Role::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                ->paginate(config('rancor.pagination'));
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return RoleResource::collection($roles);
	}
}
