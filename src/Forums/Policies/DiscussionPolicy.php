<?php

namespace Rancor\Forums\Policies;

use App\Models\User;
use Rancor\Forums\Models\Board;
use Rancor\Forums\Models\Discussion;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussionPolicy
{
	use HandlesAuthorization;

	/**
	 * Bypass policy for Admin users.
	 *
	 * @param  \App\Models\User  $user
	 * @param  string  $ability
	 * @return void|bool
	 */
	public function before(User $user, $ability)
	{
		if($user->is_banned) return false;
		if($user->is_admin) return true;
	}

	/**
	 * Determine whether the user can view any models.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
		return $user->hasPermission('view-forum-discussions')
				? Response::allow()
				: Response::deny('You do not have permissions to view forum discussions.');
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \Rancor\Forums\Models\Discussion  $discussion
	 * @return mixed
	 */
	public function view(User $user, Discussion $discussion)
	{
		return $discussion->author->is($user)
				|| $user->topics()->contains($discussion->board->id)
				|| $user->hasPermission('view-forum-discussions')
				? Response::allow()
				: Response::deny('You do not have permissions to view this forum discussion.');
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user, Board $board)
	{
		return $board->moderators->contains($user)
				|| $user->topics()->contains($board->id)
				|| $user->hasPermission('create-forum-discussions')
				? Response::allow()
				: Response::deny('You do not have permissions to create a discussion in this forum board.');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \Rancor\Forums\Models\Discussion  $discussion
	 * @return mixed
	 */
	public function update(User $user, Discussion $discussion)
	{
		return $user->hasPermission('update-forum-discussions')
				|| $discussion->author->is($user)
				|| $discussion->board->moderators->contains($user)
				? Response::allow()
				: Response::deny('You do not have permissions to update this forum discussion.');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \Rancor\Forums\Models\Discussion  $discussion
	 * @return mixed
	 */
	public function delete(User $user, Discussion $discussion)
	{
		return $user->hasPermission('delete-forum-discussions')
				? Response::allow()
				: Response::deny('You do not have permissions to delete this forum discussion.');
	}
}
