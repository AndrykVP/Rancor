<?php

namespace Rancor\Scanner\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Rancor\Scanner\Models\TerritoryType;

class TerritoryTypePolicy
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
	 * Determine whether the user can view the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \Rancor\Scanner\Models\TerritoryType  $territory_type
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
		return $user->hasPermission('view-any-scanner-territory-types')
				? Response::allow()
				: Response::deny('You do not have permissions to view scanner territory types.');
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \Rancor\Scanner\Models\TerritoryType  $territory_type
	 * @return mixed
	 */
	public function view(User $user, TerritoryType $territory_type)
	{
		return $user->hasPermission('view-scanner-territories')
				? Response::allow()
				: Response::deny('You do not have permissions to view this scanner territory type.');
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{    
		return $user->hasPermission('create-scanner-territory-type')
				? Response::allow()
				: Response::deny('You do not have permissions to create scanner territory types.');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function update(User $user, TerritoryType $territory_type)
	{
		return $user->hasPermission('update-scanner-territory-type')
				? Response::allow()
				: Response::deny('You do not have permissions to edit this scanner territory type.');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function delete(User $user, TerritoryType $territory_type)
	{
		return $user->hasPermission('delete-scanner-territory-type')
				? Response::allow()
				: Response::deny('You do not have permissions to delete this scanner territory type.');
	}
}
