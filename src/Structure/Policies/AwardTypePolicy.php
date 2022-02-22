<?php

namespace Rancor\Structure\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Rancor\Structure\Models\AwardType;

class AwardTypePolicy
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
		return $user->hasPermission('view-structure-award-types')
				? Response::allow()
				: Response::deny('You do not have permissions to view award types.');
	}
	
	/**
	 * Determine whether the user can view the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \Rancor\Structure\Models\AwardType  $type
	 * @return mixed
	 */
	public function view(User $user, AwardType $type)
	{
		return $user->hasPermission('view-structure-award-types')
				? Response::allow()
				: Response::deny('You do not have permissions to view this award type.');
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{    
		return $user->hasPermission('create-structure-award-types')
				? Response::allow()
				: Response::deny('You do not have permissions to create award types.');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \Rancor\Structure\Models\AwardType  $type
	 * @return mixed
	 */
	public function update(User $user, AwardType $type)
	{
		return $user->hasPermission('update-structure-award-types')
				? Response::allow()
				: Response::deny('You do not have permissions to edit this award type.');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \Rancor\Structure\Models\AwardType  $type
	 * @return mixed
	 */
	public function delete(User $user, AwardType $type)
	{
		return $user->hasPermission('delete-structure-award-types')
				? Response::allow()
				: Response::deny('You do not have permissions to delete this award type.');
	}
}
