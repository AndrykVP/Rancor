<?php

namespace Rancor\News\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use Rancor\News\Models\Tag;

class TagPolicy
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
	 * Determine whether the user can view all records of model.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
		return $user->hasPermission('view-news-tags')
				? Response::allow()
				: Response::deny('You do not have permissions to view news tags.');
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \AndrykVP\Rncor\News\Tag  $tag
	 * @return mixed
	 */
	public function view(User $user, Tag $tag)
	{
		return $user->hasPermission('view-news-tags')
				? Response::allow()
				: Response::deny('You do not have permissions to view this news tag.');
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{    
		return $user->hasPermission('create-news-tags')
				? Response::allow()
				: Response::deny('You do not have permissions to create news tags.');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \AndrykVP\Rncor\News\Tag  $tag
	 * @return mixed
	 */
	public function update(User $user, Tag $tag)
	{
		return $user->hasPermission('update-news-tags')
				? Response::allow()
				: Response::deny('You do not have permissions to edit this news tag.');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \AndrykVP\Rncor\News\Tag  $tag
	 * @return mixed
	 */
	public function delete(User $user, Tag $tag)
	{
		return $user->hasPermission('delete-news-tags')
				? Response::allow()
				: Response::deny('You do not have permissions to delete this news tag.');
	}
}
