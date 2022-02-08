<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use AndrykVP\Rancor\Auth\Http\Requests\UserFormSelf;
use AndrykVP\Rancor\Audit\Events\UserUpdate;
use App\Http\Controllers\Controller;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $user->load('rank.department.faction')->loadCount('boards','replies');

        return view('rancor::profile.show', compact('user'));
    }

    public function show(Request $request, User $user): View
    {
        if($request->user()->is($user)) return redirect(route('profile.index'));
        
        $this->authorize('view', $user);
        $user->load('rank.department.faction')->loadCount('boards','replies');

        return view('rancor::profile.show', compact('user'));
    }

    public function edit(Request $request): View
    {
        $user = $request->user();
        $this->authorize('update', $user);

        return view('rancor::profile.edit', compact('user'));
    }

    public function update(UserFormSelf $request): RedirectResponse
    {
        $user = $request->user();
        $this->authorize('update', $user);
        $user->update($request->validated());

        UserUpdate::dispatch($user, $user->wasChanged());

        return redirect(route('profile.index'))->with('alert', [
            'message' => ['model' => 'User', 'name' => $user->name, 'action' => 'updated']
        ]);
    }

    public function replies(User $user): View
    {
        $this->authorize('viewReplies', $user);
        $replies = $user->replies()->with('discussion.board.category');

        return view('rancor::forum.replies', compact('replies'));
    }
}
