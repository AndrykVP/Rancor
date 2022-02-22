<?php

namespace Rancor\Structure\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Rancor\Structure\Models\Rank;

class RankPolicy
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
	 * Determine whether the user can view all records model.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
		return $user->hasPermission('view-structure-ranks')
				? Response::allow()
				: Response::deny('You do not have permissions to view ranks.');
	}
	
	/**
	 * Determine whether the user can view the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \Rancor\Structure\Models\Rank  $rank
	 * @return mixed
	 */
	public function view(User $user, Rank $rank)
	{
		return $user->hasPermission('view-structure-ranks')
				? Response::allow()
				: Response::deny('You do not have permissions to view this rank.');
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{    
		return $user->hasPermission('create-structure-ranks')
				? Response::allow()
				: Response::deny('You do not have permissions to create ranks.');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \Rancor\Structure\Models\Rank  $rank
	 * @return mixed
	 */
	public function update(User $user, Rank $rank)
	{
		return $user->hasPermission('update-structure-ranks')
				? Response::allow()
				: Response::deny('You do not have permissions to edit this rank.');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \Rancor\Structure\Models\Rank  $rank
	 * @return mixed
	 */
	public function delete(User $user, Rank $rank)
	{
		return $user->hasPermission('delete-structure-ranks')
				? Response::allow()
				: Response::deny('You do not have permissions to delete this rank.');
	}
}
