<?php

namespace AndrykVP\Rancor\Forums\Policies;

use App\Models\User;
use AndrykVP\Rancor\Forums\Models\Discussion;
use AndrykVP\Rancor\Forums\Models\Reply;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
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
        return $user->hasPermission('view-forum-replies')
                ? Response::allow()
                : Response::deny('You do not have Permissions to View Forum Replies.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AndrykVP\Rancor\Forums\Models\Reply  $reply
     * @return mixed
     */
    public function view(User $user, Reply $reply)
    {
        return $reply->author->is($user)
                || $user->topics()->contains($reply->discussion->board->id)
                ? Response::allow()
                : Response::deny('You do not have Permissions to View this Forum Reply.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Discussion $discussion)
    {
        return !$discussion->is_locked
                || $discussion->author->is($user)
                || $discussion->board->moderators->contains($user)
                || $user->hasPermission('create-forum-replies')
                ? Response::allow()
                : Response::deny('You do not have Permissions to Reply to this Forum Discussion.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AndrykVP\Rancor\Forums\Models\Reply  $reply
     * @return mixed
     */
    public function update(User $user, Reply $reply)
    {
        return $user->hasPermission('update-forum-replies')
                || $reply->author->is($user)
                || $reply->discussion->board->moderators->contains($user)
                ? Response::allow()
                : Response::deny('You do not have Permissions to Update this Forum Reply.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AndrykVP\Rancor\Forums\Models\Reply  $reply
     * @return mixed
     */
    public function delete(User $user, Reply $reply)
    {
        return $user->hasPermission('delete-forum-replies')
                || $reply->discussion->board->moderators->contains($user)
                ? Response::allow()
                : Response::deny('You do not have Permissions to Delete this Forum Reply.');
    }
}
