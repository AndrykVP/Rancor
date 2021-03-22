<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Auth\Http\Requests\UserForm;
use AndrykVP\Rancor\Auth\Http\Resources\UserResource;

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

        $user->load('rank.department.faction','awards.type','permissions','roles','groups');

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
        $data = $request->validated();

        DB::transaction(function () use(&$user, $data) {
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
            if($request->user()->can('changeRank', $user))
            {
                $user->rank_id = $data['rank_id'];
            }
            if($request->user()->can('uploadArt', $user))
            {
                if($request->has('avatar'))
                {
                    $avatarPath = $request->file('avatar')->storeAs('ids/avatars/', $user->id . '.png');
                }
                if($request->has('signature'))
                {
                    $signaturePath = $request->file('signature')->storeAs('ids/signatures/', $user->id . '.png');
                }
            }
            if($request->user()->can('changeRoles', $user))
            {
                $user->roles()->sync($data['roles']);
            }
            if($request->user()->can('changeGroups', $user))
            {
                $user->groups()->sync($data['groups']);
            }

            $user->save();
        });

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny',User::class);
        
        $users = User::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return UserResource::collection($users);
    }
}