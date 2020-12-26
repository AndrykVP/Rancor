<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers;

use AndrykVP\Rancor\Auth\Role;
use AndrykVP\Rancor\Auth\Permission;
use AndrykVP\Rancor\Auth\Http\Requests\RoleForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
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
        $this->authorize('viewAny', Role::class);

        $roles = Role::paginate(config('rancor.pagination'));

        return view('rancor::roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        $permissions = Permission::all();
        
        return view('rancor::roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Auth\Http\Requests\RoleForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleForm $request)
    {
        $this->authorize('create', Role::class);

        $data = $request->validated();
        $role;

        DB::transaction(function () use($role, $data) {
            $role = Role::create($data);
            $role->permissions()->sync($data['permissions']);
        });
        
        return redirect(route('roles.index'))->with('alert', 'Role "'.$role->name.' has been successfully created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);

        $permissions = Permission::all();

        return view('rancor::roles.edit', compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Auth\Http\Requests\RoleForm  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleForm $request, Role $role)
    {
        $this->authorize('update', $role);

        $data = $request->validated();

        DB::transaction(function () use($role,$data) {
            $role->update($data);
            $role->permissions()->sync($data['permissions']);
        });

        return redirect(route('roles.index'))->with('alert', 'Role "'.$role->name.' has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);
        
        $role->delete();

        return redirect(route('roles.index'))->with('alert', 'Role "'.$role->name.' has been successfully deleted');
    }
}
