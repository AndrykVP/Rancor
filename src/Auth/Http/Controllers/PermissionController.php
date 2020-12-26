<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers;

use AndrykVP\Rancor\Auth\Permission;
use AndrykVP\Rancor\Auth\Http\Requests\PermissionForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Construct Controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware(config('rancor.middleware.web'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Permission::class);

        $permissions = Permission::paginate(config('rancor.pagination'));

        return view('rancor::permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Permission::class);

        $permissions = Permission::all();
        
        return view('rancor::permissions.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Auth\Http\Requests\PermissionForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionForm $request)
    {
        $this->authorize('create', Permission::class);

        $data = $request->validated();
        $permission;

        DB::transaction(function () use($permission, $data) {
            $permission = Permission::create($data);
            $permission->permissions()->sync($data['permissions']);
        });
        
        return redirect(route('permissions.index'))->with('alert', 'Permission "'.$permission->name.' has been successfully created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $this->authorize('update', $permission);

        return view('rancor::permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Auth\Http\Requests\PermissionForm  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionForm $request, Permission $permission)
    {
        $this->authorize('update', $permission);

        $data = $request->validated();

        DB::transaction(function () use($permission,$data) {
            $permission->update($data);
            $permission->permissions()->sync($data['permissions']);
        });

        return redirect(route('permissions.index'))->with('alert', 'Permission "'.$permission->name.' has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $this->authorize('delete', $permission);
        
        $permission->delete();

        return redirect(route('permissions.index'))->with('alert', 'Permission "'.$permission->name.' has been successfully deleted');
    }
}
