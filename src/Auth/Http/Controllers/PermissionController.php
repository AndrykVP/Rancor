<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use AndrykVP\Rancor\Auth\Models\Permission;
use AndrykVP\Rancor\Auth\Http\Requests\PermissionForm;
use AndrykVP\Rancor\Auth\Http\Requests\PermissionSearch;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    protected $resource = [
        'name' => 'Permission',
        'route' => 'permissions'
    ];

    public function index(): View
    {
        $this->authorize('viewAny', Permission::class);
        
        $resource = $this->resource;
        $models = Permission::paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    public function show(Permission $permission): View
    {
        $this->authorize('view', $permission);

        $permission->load('roles','users');

        return view('rancor::show.permission', compact('permission'));
    }

    public function search(PermissionSearch $request): View
    {
        $this->authorize('viewAny', Permission::class);
        
        $resource = $this->resource;
        $search = $request->validated();
        $models = Permission::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                ->paginate(config('rancor.pagination'));
        
        session()->flashInput($request->input());

        return view('rancor::resources.index', compact('models','resource'));
    }

    public function create(): View
    {
        $this->authorize('create', Permission::class);

        $resource = $this->resource;
        $form = array_merge($this->form(),['method' => 'POST']);
        
        return view('rancor::resources.create', compact('form','resource'));
    }

    public function store(PermissionForm $request): RedirectResponse
    {
        $this->authorize('create', Permission::class);

        $data = $request->validated();
        $permission = Permission::create($data);
        
        return redirect(route('admin.permissions.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $permission->name,'action' => 'created'],
        ]);
    }

    public function edit(Permission $permission): View
    {
        $this->authorize('update', $permission);

        $resource = $this->resource;
        $form = array_merge($this->form(),['method' => 'PATCH']);
        $model = $permission;

        return view('rancor::resources.edit', compact('resource','form','model'));
    }

    public function update(PermissionForm $request, Permission $permission): RedirectResponse
    {
        $this->authorize('update', $permission);

        $data = $request->validated();
        $permission->update($data);

        return redirect(route('admin.permissions.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $permission->name,'action' => 'updated']
        ]);
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $this->authorize('delete', $permission);
        
        $permission->delete();

        return redirect(route('admin.permissions.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $permission->name,'action' => 'deleted']
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
        ];
    }
}
