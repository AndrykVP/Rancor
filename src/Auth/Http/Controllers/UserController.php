<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Auth\Http\Requests\UserForm;
use AndrykVP\Rancor\Auth\Models\Role;
use AndrykVP\Rancor\Structure\Models\Faction;
use AndrykVP\Rancor\Structure\Models\Department;
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

        $user->load('rank.department.faction','roles','permissions','user_changelog.creator', 'awards');

        return view('rancor::show.user', compact('user'));
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

        return view('rancor::users.edit', compact('user','factions','departments','ranks','roles'));
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
        
        $user->name = $data['name'];
        $user->nickname = $data['nickname'];
        $user->email = $data['email'];
        $user->quote = $data['quote'];

        if($request->user()->can('changeRank', $user))
        {
            $user->rank_id = $data['rank_id'];
        }
        if($request->user()->can('uploadArt', $user))
        {
            if($request->has('avatar'))
            {
                $avatarPath = $request->file('avatar')->storeAs('idgen/avatars', $user->id . '.png');
            }
            if($request->has('signature'))
            {
                $signaturePath = $request->file('signature')->storeAs('idgen/signatures', $user->id . '.png');
            }
        }
        if($request->user()->can('changeRoles', $user))
        {
            $user->roles()->sync($data['roles']);
        }

        $user->save();

        return redirect(route('admin.users.index'))->with('alert', 'User "'.$user->name.'" has been successfully updated.');

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

        return redirect(route('admin.users.index'))->with('alert', 'User "'.$user->name.'" has been successfully deleted.');
    }
}
