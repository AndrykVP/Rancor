<?php

namespace AndrykVP\Rancor\Forums\Policies;

use App\Models\User;
use AndrykVP\Rancor\Forums\Models\Board;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardPolicy
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
        return $user->hasPermission('view-forum-boards')
                ? Response::allow()
                : Response::deny('You do not have Permissions to View Forum Boards.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AndrykVP\Rancor\Forums\Models\Board  $board
     * @return mixed
     */
    public function view(User $user, Board $board)
    {
        return $board->moderators->contains($user)
                || $user->topics()->contains($board->id)
                || $user->hasPermission('view-forum-boards')
                ? Response::allow()
                : Response::deny('You do not have Permissions to View this Forum Board.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create-forum-boards')
                ? Response::allow()
                : Response::deny('You do not have Permissions to Create Forum Boards.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AndrykVP\Rancor\Forums\Models\Board  $board
     * @return mixed
     */
    public function update(User $user, Board $board)
    {
        return $board->moderators->contains($user)
                ||$user->hasPermission('update-forum-boards')
                ? Response::allow()
                : Response::deny('You do not have Permissions to Update this Forum Board.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AndrykVP\Rancor\Forums\Models\Board  $board
     * @return mixed
     */
    public function delete(User $user, Board $board)
    {
        return $user->hasPermission('delete-forum-boards')
                ? Response::allow()
                : Response::deny('You do not have Permissions to Delete this Forum Board.');
    }
}
