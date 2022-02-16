<?php

namespace Rancor\Forums\Policies;

use App\Models\User;
use Rancor\Forums\Models\Discussion;
use Rancor\Forums\Models\Reply;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
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
		return $user->hasPermission('view-forum-replies')
				? Response::allow()
				: Response::deny('You do not have permissions to view forum replies.');
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \Rancor\Forums\Models\Reply  $reply
	 * @return mixed
	 */
	public function view(User $user, Reply $reply)
	{
		return $reply->author->is($user)
				|| $user->topics()->contains($reply->discussion->board->id)
				? Response::allow()
				: Response::deny('You do not have permissions to view this forum reply.');
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user, Discussion $discussion)
	{
		return ($user->topics()->contains($discussion->board->id)
				&& !$discussion->is_locked)
				|| $discussion->author->is($user)
				|| $discussion->board->moderators->contains($user)
				|| $user->hasPermission('create-forum-replies')
				? Response::allow()
				: Response::deny('You do not have permissions to reply to this forum discussion.');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \Rancor\Forums\Models\Reply  $reply
	 * @return mixed
	 */
	public function update(User $user, Reply $reply)
	{
		return $user->hasPermission('update-forum-replies')
				|| $reply->author->is($user)
				|| $reply->discussion->board->moderators->contains($user)
				? Response::allow()
				: Response::deny('You do not have permissions to update this forum reply.');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \Rancor\Forums\Models\Reply  $reply
	 * @return mixed
	 */
	public function delete(User $user, Reply $reply)
	{
		return $user->hasPermission('delete-forum-replies')
				|| $reply->discussion->board->moderators->contains($user)
				? Response::allow()
				: Response::deny('You do not have permissions to delete this forum reply.');
	}
}
