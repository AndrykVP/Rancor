<?php

namespace Rancor\Auth\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
<<<<<<< HEAD
use App\Http\Controllers\Controller;
use Rancor\Auth\Http\Requests\UserFormSelf;
use Rancor\Audit\Events\UserUpdate;
=======
use Illuminate\Contracts\View\View;
use AndrykVP\Rancor\Auth\Http\Requests\UserFormSelf;
use AndrykVP\Rancor\Audit\Events\UserUpdate;
use App\Http\Controllers\Controller;
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
use App\Models\User;

class ProfileController extends Controller
{
<<<<<<< HEAD
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$user = $request->user();
		$user->load('rank.department.faction')->loadCount('boards','replies');
=======
    public function index(Request $request): View
    {
        $user = $request->user();
        $user->load('rank.department.faction')->loadCount('boards','replies');
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return view('rancor::profile.show', compact('user'));
	}

<<<<<<< HEAD
	/**
	 * Display the specified resource.
	 *
	 * @param \Illuminate\Http\Request  $request
	 * @param  \App\Models\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, User $user)
	{
		if($request->user()->is($user)) return redirect(route('profile.index'));
		
		$this->authorize('view', $user);
		$user->load('rank.department.faction')->loadCount('boards','replies');
=======
    public function show(Request $request, User $user): View
    {
        if($request->user()->is($user)) return redirect(route('profile.index'));
        
        $this->authorize('view', $user);
        $user->load('rank.department.faction')->loadCount('boards','replies');
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return view('rancor::profile.show', compact('user'));
	}

<<<<<<< HEAD
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param \Illuminate\Http\Request
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request)
	{
		$user = $request->user();
		$this->authorize('update', $user);
=======
    public function edit(Request $request): View
    {
        $user = $request->user();
        $this->authorize('update', $user);
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return view('rancor::profile.edit', compact('user'));
	}

<<<<<<< HEAD
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Rancor\Auth\Http\Requests\UserFormSelf  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(UserFormSelf $request)
	{
		$user = $request->user();
		$this->authorize('update', $user);
		$user->update($request->validated());
=======
    public function update(UserFormSelf $request): RedirectResponse
    {
        $user = $request->user();
        $this->authorize('update', $user);
        $user->update($request->validated());
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		UserUpdate::dispatch($user, $user->wasChanged());

		return redirect(route('profile.index'))->with('alert', [
			'message' => ['model' => 'User', 'name' => $user->name, 'action' => 'updated']
		]);
	}

<<<<<<< HEAD
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
=======
    public function replies(User $user): View
    {
        $this->authorize('viewReplies', $user);
        $replies = $user->replies()->with('discussion.board.category');
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return view('rancor::forum.replies', compact('replies'));
	}
}
