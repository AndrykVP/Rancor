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
        $this->authorize('view',User::class);
        
        $query = User::paginate(15);

        return UserResource::collection($query);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->user()->id != $id)
        {
            $this->authorize('view',User::class);
        }
        
        $query = User::findOrFail($id);

        return new UserResource($query);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserForm $request, $id)
    {
        $query = User::findOrFail($id);
        $data = $request->all();

        if($request->user()->can('update', User::class) || $request->user()->id == $id)
        {
            $query->name = $data['name'];
            $query->email = $data['email'];

            if($request->has('nickname'))
            {
                $query->nickname = $data['nickname'];
            }
        }

        if($request->user()->can('update', User::class) || $request->user()->can('changeRank', User::class))
        {
            if($request->has('rank_id'))
            {
                $query->rank_id = $data['rank_id'];
            }
        }

        if($request->user()->can('update', User::class) || $request->user()->can('changePrivs', User::class))
        {
            if($request->has('permissions'))
            {
                $query->permissions()->sync($request->permissions);
            }
            if($request->has('roles'))
            {
                $query->roles()->sync($request->roles);
            }
        }

        $query->save();

        return response()->json([
            'message' => 'User "'.$query->name.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete',User::class);
        
        $query = User::findOrFail($id);
        $query->delete();

        return response()->json([
            'message' => 'User "'.$query->name.'" has been deleted'
        ], 200);        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('view',User::class);
        
        $query = User::where('name','like','%'.$request->search.'%')->paginate(15);

        return UserResource::collection($query);
    }
}