<?php

namespace Rancor\Auth\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
<<<<<<< HEAD
use Rancor\Auth\Models\Role;
=======
use AndrykVP\Rancor\Auth\Models\Role;
use App\Models\User;
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

class RolePolicy
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
		return $user->hasPermission('view-roles')
				? Response::allow()
				: Response::deny('You do not have permissions to view roles.');
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \Rancor\Auth\Models\Role  $role
	 * @return mixed
	 */
	public function view(User $user, Role $role)
	{
		return $user->hasPermission('view-roles')
				? Response::allow()
				: Response::deny('You do not have permissions to view this role.');
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{    
		return $user->hasPermission('create-roles')
				? Response::allow()
				: Response::deny('You do not have permissions to create roles.');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \Rancor\Auth\Models\Role  $role
	 * @return mixed
	 */
	public function update(User $user, Role $role)
	{
		return $user->hasPermission('update-roles')
				? Response::allow()
				: Response::deny('You do not have permissions to edit this role.');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \Rancor\Auth\Models\Role  $role
	 * @return mixed
	 */
	public function delete(User $user, Role $role)
	{
		return $user->hasPermission('delete-roles')
				? Response::allow()
				: Response::deny('You do not have permissions to delete this role.');
	}
}
