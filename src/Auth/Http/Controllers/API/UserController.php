<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Auth\Http\Requests\UserForm;
use AndrykVP\Rancor\Auth\Http\Requests\UserSearch;
use AndrykVP\Rancor\Auth\Http\Resources\UserResource;
use AndrykVP\Rancor\Auth\Services\AdminUpdatesUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',User::class);
        
        $query = User::paginate(config('rancor.pagination'));

        return UserResource::collection($query);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $user->load('rank.department.faction', 'awards.type', 'permissions', 'roles', 'groups');

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AndrykVP\Rancor\Auth\Http\Requests\UserForm  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserForm $request, User $user)
    {
        $this->authorize('update',$user);
        $service = new AdminUpdatesUser;
        $service($request, $user);

        return response()->json([
            'message' => 'User "'.$user->name.'" has been updated'
        ], 200);
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

        return response()->json([
            'message' => 'User "'.$user->name.'" has been deleted'
        ], 200);        
    }

    /**
     * Display the results that match the search query.
     *
     * @param  \AndrykVP\Rancor\Auth\Http\Requests\UserSearch  $request
     * @return \Illuminate\Http\Response
     */
    public function search(UserSearch $request)
    {
        $this->authorize('viewAny',User::class);
        $search = $request->validated();
        $users = User::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                ->paginate(config('rancor.pagination'));

        return UserResource::collection($users);
    }
}