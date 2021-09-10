<?php

namespace AndrykVP\Rancor\Scanner\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use AndrykVP\Rancor\Scanner\Models\Quadrant;

class QuadrantPolicy
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
     * @param  \AndrykVP\Rancor\Scanner\Models\Quadrant  $quadrant
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-any-scanner-quadrants')
                ? Response::allow()
                : Response::deny('You do not have permissions to view scanner quadrants.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AndrykVP\Rancor\Scanner\Models\Quadrant  $quadrant
     * @return mixed
     */
    public function view(User $user, Quadrant $quadrant)
    {
        return $user->hasPermission('view-scanner-quadrants')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this scanner quadrant.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {    
        return $user->hasPermission('create-scanner-quadrants')
                ? Response::allow()
                : Response::deny('You do not have permissions to create scanner quadrants.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user, Quadrant $quadrant)
    {
        return $user->hasPermission('update-scanner-quadrants')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this scanner quadrant.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user, Quadrant $quadrant)
    {
        return $user->hasPermission('delete-scanner-quadrants')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this scanner quadrant.');
    }
}
