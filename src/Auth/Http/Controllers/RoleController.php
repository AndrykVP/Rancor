<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers;

use AndrykVP\Rancor\Auth\Role;
use AndrykVP\Rancor\Auth\Permission;
use AndrykVP\Rancor\Auth\Http\Requests\RoleForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Role',
        'route' => 'roles'
    ];

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

        $resource = $this->resource;
        $models = Role::paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Auth\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $this->authorize('view', $role);

        $role->load('permissions','users');

        return view('rancor::show.role', compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        $resource = $this->resource;
        $form = array_merge($this->form(),['method' => 'POST']);
        
        return view('rancor::resources.create', compact('resource','form'));
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

        DB::transaction(function () use(&$role, $data) {
            $role = Role::create($data);
            $role->permissions()->sync($data['permissions']);
        });
        
        return redirect(route('admin.roles.index'))->with('alert', 'Role "'.$role->name.' has been successfully created');
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

        $resource = $this->resource;
        $form = array_merge($this->form(),['method' => 'PATCH']);
        $model = $role;

        return view('rancor::resources.edit', compact('resource','model','form'));
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

        DB::transaction(function () use(&$role,$data) {
            $role->update($data);
            $role->permissions()->sync($data['permissions']);
        });

        return redirect(route('admin.roles.index'))->with('alert', 'Role "'.$role->name.' has been successfully updated');
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
        
        $roles->permissions()->detach();
        $role->delete();

        return redirect(route('admin.roles.index'))->with('alert', 'Role "'.$role->name.' has been successfully deleted');
    }

    /**
     * Variable for Form fields used in Create and Edit Views
     * 
     * @var array
     */
    protected function form()
    {
        return [
            'inputs' => [
                [
                    'name' => 'name',
                    'label' => 'Name',
                    'type' => 'text',
                    'attributes' => 'autofocus required'
                ],
                [
                    'name' => 'description',
                    'label' => 'Description',
                    'type' => 'text',
                    'attributes' => 'required'
                ],
            ],
            'selects' => [
                [
                    'name' => 'permissions',
                    'label' => 'Permissions',
                    'attributes' => 'multiple',
                    'multiple' => true,
                    'options' => Permission::all(),
                ]
            ],
        ];
    }
}
