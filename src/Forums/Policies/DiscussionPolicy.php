<?php

namespace AndrykVP\Rancor\Forums\Policies;

use App\User;
use AndrykVP\Rancor\Forums\Discussion;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-forum-discussions')
                ? Response::allow()
                : Response::deny('You do not have Permissions to View Forum Discussions.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \AndrykVP\Rancor\Forums\Discussion  $discussion
     * @return mixed
     */
    public function view(User $user, Discussion $discussion)
    {
        return $discussion->author_id == $user->id
                || $user->topics()->contains($discussion->board->id)
                ? Response::allow()
                : Response::deny('You do not have Permissions to View this Forum Discussion.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create-forum-discussions')
                ? Response::allow()
                : Response::deny('You do not have Permissions to Create Forum Discussions.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \AndrykVP\Rancor\Forums\Discussion  $discussion
     * @return mixed
     */
    public function update(User $user, Discussion $discussion)
    {
        return ( $user->hasPermission('update-forum-discussions')
                || $discussion->author_id == $user->id
                || $discussion->board->moderators->contains($user) )
                ? Response::allow()
                : Response::deny('You do not have Permissions to Update this Forum Discussion.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \AndrykVP\Rancor\Forums\Discussion  $discussion
     * @return mixed
     */
    public function delete(User $user, Discussion $discussion)
    {
        return $user->hasPermission('delete-forum-discussions')
                ? Response::allow()
                : Response::deny('You do not have Permissions to Delete this Forum Discussion.');
    }

    /**
     * Determine whether the user can post to the model.
     *
     * @param  \App\User  $user
     * @param  \AndrykVP\Rancor\Forums\Discussion  $discussion
     * @return mixed
     */
    public function post(User $user, Discussion $discussion)
    {
        return !$discussion->is_locked
                || $discussion->author_id === $user->id
                || $user->hasPermission('update-forum-discussions')
                ? Response::allow()
                : Response::deny('You do not have Permissions to Reply to this Forum Discussion.');
    }
}