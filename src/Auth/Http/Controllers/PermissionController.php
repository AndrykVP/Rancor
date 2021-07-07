<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers;

use AndrykVP\Rancor\Auth\Models\Permission;
use AndrykVP\Rancor\Auth\Http\Requests\PermissionForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Permission',
        'route' => 'permissions'
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
        $this->authorize('viewAny', Permission::class);
        
        $resource = $this->resource;
        $models = Permission::paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Auth\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        $this->authorize('view', $permission);

        $permission->load('roles','users');

        return view('rancor::show.permission', compact('permission'));
    }

    /**
     * Display the resources that match the search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny', Permission::class);
        
        $resource = $this->resource;
        $models = Permission::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Permission::class);

        $resource = $this->resource;
        $form = array_merge($this->form(),['method' => 'POST']);
        
        return view('rancor::resources.create', compact('form','resource'));
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
        $permission = Permission::create($data);
        
        return redirect(route('admin.permissions.index'))->with('alert', ['model' => $this->resource['name'], 'name' => $permission->name,'action' => 'created']);
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

        $resource = $this->resource;
        $form = array_merge($this->form(),['method' => 'PATCH']);
        $model = $permission;

        return view('rancor::resources.edit', compact('resource','form','model'));
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
        $permission->update($data);

        return redirect(route('admin.permissions.index'))->with('alert', ['model' => $this->resource['name'], 'name' => $permission->name,'action' => 'updated']);
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

        return redirect(route('admin.permissions.index'))->with('alert', ['model' => $this->resource['name'], 'name' => $permission->name,'action' => 'deleted']);
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
        ];
    }
}
