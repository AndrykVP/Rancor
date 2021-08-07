<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Auth\Http\Requests\UserForm;
use AndrykVP\Rancor\Auth\Models\Role;
use AndrykVP\Rancor\Structure\Models\Department;
use AndrykVP\Rancor\Structure\Models\Faction;
use AndrykVP\Rancor\Structure\Models\Rank;

class UserController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'User',
        'route' => 'users'
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
        $this->authorize('viewAny', User::class);

        $resource = $this->resource;
        $models = User::paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->load('rank.department.faction','roles','permissions','userLog.creator', 'awards');

        return view('rancor::show.user', compact('user'));
    }

    /**
     * Display the resources that match the search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny', User::class);
        
        $resource = $this->resource;
        $models = User::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        
        $user->load('rank.department.faction','roles','permissions');
        $factions = Faction::all();
        $departments = Department::all();
        $ranks = Rank::all();
        $roles = Role::all();
        $award_types = AwardType::with('awards')->orderBy('name', 'asc')->get();

        // dd($awards->toArray());

        return view('rancor::users.edit', compact('user','factions','departments','ranks','roles', 'award_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Auth\Http\Requests\UserForm  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserForm $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->validated();
        
        DB::transaction(function () use(&$user, $data, $request) {
            $user->name = $data['name'];
            $user->email = $data['email'];

            if($request->has('nickname'))
            {
                $user->nickname = $data['nickname'];
            }
            if($request->has('quote'))
            {
                $user->quote = $data['quote'];
            }
            if($request->has('rank_id') && $request->user()->can('changeRank', $user))
            {
                $user->rank_id = $data['rank_id'];
            }
            if($request->user()->can('uploadArt', $user))
            {
                if($request->hasFile('avatar'))
                {
                    $avatarPath = $request->file('avatar')->storeAs('ids/avatars/', $user->id . '.png');
                }
                if($request->hasFile('signature'))
                {
                    $signaturePath = $request->file('signature')->storeAs('ids/signatures/', $user->id . '.png');
                }
            }
            if($request->has('roles') && $request->user()->can('changeRoles', $user))
            {
                $user->roles()->sync($data['roles']);
            }
            if($request->has('awards') && $request->user()->can('changeAwards', $user))
            {
                $user->awards()->sync($data['awards']);
            }
            if($request->has('groups') && $request->user()->can('changeGroups', $user))
            {
                $user->groups()->sync($data['groups']);
            }

            $user->save();
        });

        return redirect(route('admin.users.index'))->with('alert', ['model' => $this->resource['name'], 'name' => $user->name,'action' => 'updated']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect(route('admin.users.index'))->with('alert', ['model' => $this->resource['name'], 'name' => $user->name,'action' => 'deleted']);
    }
}
