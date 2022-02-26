<?php

namespace Rancor\Auth\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class UserPolicy
{
	use HandlesAuthorization;

<<<<<<< HEAD
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
	 * Determine whether the user can view all records of model.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
		return $user->hasPermission('view-users')
				? Response::allow()
				: Response::deny('You do not have permissions to view users.');
	}

	/**
	 * Determine whether the user can view the model's replies.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\User  $model
	 * @return mixed
	 */
	public function viewReplies(User $user, User $model)
	{
		return $user->is($model)
				|| $user->hasPermission('view-forum-replies')
				? Response::allow()
				: Response::deny('You do not have permissions to view this user.');
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\User  $model
	 * @return mixed
	 */
	public function view(User $user, User $model)
	{
		return $user->is($model)
				|| $user->hasPermission('view-users')
				? Response::allow()
				: Response::deny('You do not have permissions to view this user.');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\User  $model
	 * @return mixed
	 */
	public function update(User $user, User $model)
	{
		return $user->is($model)
				|| $user->hasPermission('update-users')
				|| $user->hasPermission('update-users-art')
				|| $user->hasPermission('update-users-rank')
				|| $user->hasPermission('update-users-roles')
				|| $user->hasPermission('update-users-awards')
				? Response::allow()
				: Response::deny('You do not have permissions to edit this user.');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function uploadArt(User $user)
	{
		return $user->hasPermission('update-users-art')
				? Response::allow()
				: Response::deny('You do not have permissions to upload artwork to this user.');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\User  $model
	 * @return mixed
	 */
	public function changeRank(User $user, User $model)
	{
		return $user->hasPermission('update-users-rank')
				? Response::allow()
				: Response::deny('You do not have permissions to change this user\'s faction info.');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\User  $model
	 * @return mixed
	 */
	public function changeRoles(User $user, User $model)
	{
		return $user->hasPermission('update-users-roles')
				&& $user->isNot($model)
				? Response::allow()
				: Response::deny('You do not have permissions to change this user\'s roles.');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\User  $model
	 * @return mixed
	 */
	public function changeAwards(User $user, User $model)
	{
		return $user->hasPermission('update-users-awards')
				&& $user->isNot($model)
				? Response::allow()
				: Response::deny('You do not have permissions to change this user\'s awards.');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function delete(User $user, User $model)
	{
		return $user->hasPermission('delete-users')
				&& $user->isNot($model)
				? Response::allow()
				: Response::deny('You do not have permissions to delete this user.');
	}

	/**
	 * Determine whether the user can ban the model.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function ban(User $user, User $model)
	{
		return $user->hasPermission('ban-users')
				&& $user->isNot($model)
				? Response::allow()
				: Response::deny('You do not have permissions to delete this user.');
	}
=======
    public function before(User $user, String $ability): bool
    {
        if($user->is_banned) return false;
        if($user->is_admin) return true;
    }

    public function viewAny(User $user): Response
    {
        return $user->hasPermission('view-users')
                ? Response::allow()
                : Response::deny('You do not have permissions to view users.');
    }

    public function viewReplies(User $user, User $model): Response
    {
        return $user->is($model)
                || $user->hasPermission('view-forum-replies')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this user\'s replies.');
    }

    public function view(User $user, User $model): Response
    {
        return $user->is($model)
                || $user->hasPermission('view-users')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this user.');
    }

    public function update(User $user, User $model): Response
    {
        return $user->is($model)
                || $user->hasPermission('update-users')
                || $user->hasPermission('update-users-art')
                || $user->hasPermission('update-users-rank')
                || $user->hasPermission('update-users-roles')
                || $user->hasPermission('update-users-awards')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this user.');
    }

    public function uploadArt(User $user): Response
    {
        return $user->hasPermission('update-users-art')
                ? Response::allow()
                : Response::deny('You do not have permissions to upload artwork to this user.');
    }

    public function changeRank(User $user, User $model): Response
    {
        return $user->hasPermission('update-users-rank')
                ? Response::allow()
                : Response::deny('You do not have permissions to change this user\'s faction info.');
    }

    public function changeRoles(User $user, User $model): Response
    {
        return $user->hasPermission('update-users-roles')
                && $user->isNot($model)
                ? Response::allow()
                : Response::deny('You do not have permissions to change this user\'s roles.');
    }

    public function changeAwards(User $user, User $model): Response
    {
        return $user->hasPermission('update-users-awards')
                && $user->isNot($model)
                ? Response::allow()
                : Response::deny('You do not have permissions to change this user\'s awards.');
    }

    public function delete(User $user, User $model): Response
    {
        return $user->hasPermission('delete-users')
                && $user->isNot($model)
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this user.');
    }

    public function ban(User $user, User $model): Response
    {
        return $user->hasPermission('ban-users')
                && $user->isNot($model)
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this user.');
    }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
