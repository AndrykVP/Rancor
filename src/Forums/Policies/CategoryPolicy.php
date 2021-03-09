<?php

namespace AndrykVP\Rancor\Forums\Policies;

use App\Models\User;
use AndrykVP\Rancor\Forums\Models\Category;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-forum-categories')
                ? Response::allow()
                : Response::deny('You do not have permissions to View Forum Categories.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AndrykVP\Rancor\Forums\Category  $category
     * @return mixed
     */
    public function view(User $user, Category $category)
    {
        return $user->categories()->contains($category->id)
                || $user->hasPermission('view-forum-categories')
                ? Response::allow()
                : Response::deny('You do not have permissions to View this Forum Category.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create-forum-categories')
                ? Response::allow()
                : Response::deny('You do not have permissions to Create Forum Categories.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AndrykVP\Rancor\Forums\Category  $category
     * @return mixed
     */
    public function update(User $user, Category $category)
    {
        return $user->hasPermission('update-forum-categories')
                ? Response::allow()
                : Response::deny('You do not have permissions to Update this Forum Category.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AndrykVP\Rancor\Forums\Category  $category
     * @return mixed
     */
    public function delete(User $user, Category $category)
    {
        return $user->hasPermission('delete-forum-categories')
                ? Response::allow()
                : Response::deny('You do not have permissions to Delete this Forum Category.');
    }
}
