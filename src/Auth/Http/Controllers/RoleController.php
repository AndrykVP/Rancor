<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use AndrykVP\Rancor\Auth\Models\Role;
use AndrykVP\Rancor\Auth\Models\Permission;
use AndrykVP\Rancor\Auth\Http\Requests\RoleForm;
use AndrykVP\Rancor\Auth\Http\Requests\RoleSearch;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    protected $resource = [
        'name' => 'Role',
        'route' => 'roles'
    ];

    public function index(): View
    {
        $this->authorize('viewAny', Role::class);

        $resource = $this->resource;
        $models = Role::paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    public function show(Role $role): View
    {
        $this->authorize('view', $role);

        $role->load('permissions','users');

        return view('rancor::show.role', compact('role'));
    }

    public function search(RoleSearch $request): View
    {
        $this->authorize('viewAny', Role::class);
        
        $resource = $this->resource;
        $search = $request->validated();
        $models = Role::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                ->paginate(config('rancor.pagination'));
        
        session()->flashInput($request->input());
        return view('rancor::resources.index', compact('models','resource'));
    }

    public function create(): View
    {
        $this->authorize('create', Role::class);

        $resource = $this->resource;
        $form = array_merge($this->form(),['method' => 'POST']);
        
        return view('rancor::resources.create', compact('resource','form'));
    }

    public function store(RoleForm $request): RedirectResponse
    {
        $this->authorize('create', Role::class);

        $data = $request->validated();
        $role;

        DB::transaction(function () use(&$role, $data) {
            $role = Role::create($data);
            $role->permissions()->sync($data['permissions']);
        });
        
        return redirect(route('admin.roles.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $role->name,'action' => 'created']
        ]);
    }

    public function edit(Role $role): View
    {
        $this->authorize('update', $role);

        $resource = $this->resource;
        $form = array_merge($this->form(),['method' => 'PATCH']);
        $model = $role;

        return view('rancor::resources.edit', compact('resource','model','form'));
    }

    public function update(RoleForm $request, Role $role): RedirectResponse
    {
        $this->authorize('update', $role);

        $data = $request->validated();

        DB::transaction(function () use(&$role,$data) {
            $role->update($data);
            $role->permissions()->sync($data['permissions']);
        });

        return redirect(route('admin.roles.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $role->name,'action' => 'updated']
        ]);
    }

    public function destroy(Role $role): RedirectResponse
    {
        $this->authorize('delete', $role);
        
        DB::transaction(function() use($role) {
            $role->permissions()->detach();
            $role->delete();
        });

        return redirect(route('admin.roles.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $role->name,'action' => 'deleted']
        ]);
    }

    protected function form(): array
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
