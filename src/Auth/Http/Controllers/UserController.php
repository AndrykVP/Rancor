<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\User;
use AndrykVP\Rancor\Auth\Http\Resources\UserResource;
use AndrykVP\Rancor\Auth\Http\Requests\UserForm;

class UserController extends Controller
{
    /**
     * Construct Controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware(config('rancor.middleware'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',User::class);
        
        $query = User::paginate(15);

        return UserResource::collection($query);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $this->authorize('view',$user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AndrykVP\Rancor\Auth\Http\Requests\UserForm  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserForm $request, User $user)
    {
        $data = $request->validated();

        $this->authorize('update',$user);
        $user->name = $data['name'];
        $user->email = $data['email'];

        if($request->has('nickname'))
        {
            $user->nickname = $data['nickname'];
        }

        if($request->has('rank_id') && $request->user()->can('changeRank', $user))
        {
            $user->rank_id = $data['rank_id'];
        }

        if($request->user()->can('changePrivs', $user))
        {
            if($request->has('permissions'))
            {
                $user->permissions()->sync($request->permissions);
            }
            if($request->has('roles'))
            {
                $user->roles()->sync($request->roles);
            }
        }

        $user->save();

        return response()->json([
            'message' => 'User "'.$user->name.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
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
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny',User::class);
        
        $query = User::where('name','like','%'.$request->input('search').'%')->paginate(15);

        return UserResource::collection($query);
    }
}