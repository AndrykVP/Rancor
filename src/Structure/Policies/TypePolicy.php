<?php

namespace AndrykVP\Rancor\Structure\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use AndrykVP\Rancor\Structure\Models\Type;

class TypePolicy
{
    use HandlesAuthorization;

    /**
     * Bypass policy for Admin users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view all records of model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-structure-awards')
                ? Response::allow()
                : Response::deny('You do not have permissions to view awards.');
    }
    
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rancor\Structure\Models\Type  $type
     * @return mixed
     */
    public function view(User $user, Tpye $type)
    {
        return $user->hasPermission('view-structure-awards')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this award.');
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
     * @param \AndrykVP\Rancor\Structure\Models\Rank  $rank
     * @return mixed
     */
    public function update(User $user, Type $type)
    {
        return $user->hasPermission('update-structure-award-types')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this award type.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rancor\Structure\Models\Rank  $rank
     * @return mixed
     */
    public function delete(User $user, Type $type)
    {
        return $user->hasPermission('delete-structure-award-types')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this award type.');
    }
}
