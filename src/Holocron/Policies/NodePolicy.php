<?php

namespace AndrykVP\Rancor\Holocron\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use AndrykVP\Rancor\Holocron\Models\Node;

class NodePolicy
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
        return $user->hasPermission('view-holocron-nodes')
                ? Response::allow()
                : Response::deny('You do not have permissions to view holocron nodes.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rncor\News\Node  $node
     * @return mixed
     */
    public function view(?User $user, Node $node)
    {
        return $node->is_public
                ||$user->id === $node->author_id
                ||$user->id === $node->editor_id
                ||$user->hasPermission('view-holocron-nodes')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this holocron node.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {    
        return $user->hasPermission('create-holocron-nodes')
                ? Response::allow()
                : Response::deny('You do not have permissions to create holocron nodes.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rncor\News\Node  $node
     * @return mixed
     */
    public function update(User $user, Node $node)
    {
        return $user->id === $node->author_id
                ||$user->hasPermission('update-holocron-nodes')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this holocron node.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rncor\News\Node  $node
     * @return mixed
     */
    public function delete(User $user, Node $node)
    {
        return $user->id === $node->author_id
                || $user->hasPermission('delete-holocron-nodes')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this holocron node.');
    }
}
