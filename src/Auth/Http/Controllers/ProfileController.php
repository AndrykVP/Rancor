<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Auth\Http\Requests\UserFormSelf;
use App\Models\User;
use Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return $this->show($user);
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

        $user->load('rank.department.faction')->loadCount('boards','replies');

        return view('rancor::profile.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        $this->authorize('update', $user);
        
        $user->load('rank.department.faction');

        return view('rancor::profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Auth\Http\Requests\UserFormSelf  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormSelf $request)
    {
        $user = Auth::user();
        $this->authorize('update', $user);

        $data = $request->validated();
        
        $user->update($data);


        return redirect(route('profile.index'))->with('alert', [
            'message' => ['model' => 'User', 'name' => $user->name, 'action' => 'created']
        ]);
    }

    /**
     * Show the replies posted by the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function replies(User $user)
    {
        $this->authorize('viewReplies', $user);

        $replies = $user->replies()->with('discussion.board.category');

        return view('rancor::forum.replies', compact('replies'));
    }
}
