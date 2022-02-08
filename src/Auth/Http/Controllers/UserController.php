<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use AndrykVP\Rancor\Auth\Http\Requests\BanForm;
use AndrykVP\Rancor\Auth\Http\Requests\UserForm;
use AndrykVP\Rancor\Auth\Http\Requests\UserSearch;
use AndrykVP\Rancor\Auth\Models\Role;
use AndrykVP\Rancor\Auth\Services\AdminUpdatesUser;
use AndrykVP\Rancor\Structure\Models\Department;
use AndrykVP\Rancor\Structure\Models\Faction;
use AndrykVP\Rancor\Structure\Models\Rank;
use AndrykVP\Rancor\Structure\Models\AwardType;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    protected $resource = [
        'name' => 'User',
        'route' => 'users'
    ];

    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        $resource = $this->resource;
        $models = User::paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models', 'resource'));
    }

    public function show(User $user): View
    {
        $this->authorize('view', $user);

        $user->load('rank.department.faction', 'roles', 'permissions', 'userLog.creator', 'awards');

        return view('rancor::show.user', compact('user'));
    }

    public function search(UserSearch $request): View
    {
        $this->authorize('viewAny', User::class);
        
        $resource = $this->resource;
        $search = $request->validated();
        $models = User::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                ->paginate(config('rancor.pagination'));

        session()->flashInput($request->input());
        return view('rancor::resources.index', compact('models', 'resource'));
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);
        
        $user->load('rank.department.faction', 'roles', 'permissions', 'awards');
        $factions = Faction::all();
        $departments = Department::all();
        $ranks = Rank::all();
        $roles = Role::all();
        $award_types = AwardType::with('awards')->orderBy('name', 'asc')->get();

        return view('rancor::users.edit', compact('user', 'factions', 'departments', 'ranks', 'roles', 'award_types'));
    }

    public function update(UserForm $request, User $user, AdminUpdatesUser $service): RedirectResponse
    {
        $this->authorize('update', $user);
        $service($request, $user);

        return redirect(route('admin.users.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $user->name, 'action' => 'updated']
        ]);

    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect(route('admin.users.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $user->name, 'action' => 'deleted']
        ]);
    }

    public function ban(BanForm $request, User $user): RedirectResponse
    {
        $this->authorize('ban', $user);

        $data = $request->validated();
        $user->is_banned = $data['status'];
        $user->is_admin = false;

        DB::transaction(function () use($user, $data) {
            $user->save();
            $user->bans()->create($data);
        });

        return redirect(route('admin.users.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $user->name, 'action' => ($request->status ? 'banned' : 'unbanned')]
        ]);
    }
}
