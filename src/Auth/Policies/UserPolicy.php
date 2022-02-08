<?php

namespace AndrykVP\Rancor\Auth\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user, String $ability): bool
    {
        if($user->is_banned) return false;
        if($user->is_admin) return true;
    }

    public function viewAny(User $user): Response
    {
        return $user->hasPermission('view-users')
                ? Response::allow()
                : Response::deny('You do not have permissions to view users.');
    }

    public function viewReplies(User $user, User $model): Response
    {
        return $user->is($model)
                || $user->hasPermission('view-forum-replies')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this user\'s replies.');
    }

    public function view(User $user, User $model): Response
    {
        return $user->is($model)
                || $user->hasPermission('view-users')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this user.');
    }

    public function update(User $user, User $model): Response
    {
        return $user->is($model)
                || $user->hasPermission('update-users')
                || $user->hasPermission('update-users-art')
                || $user->hasPermission('update-users-rank')
                || $user->hasPermission('update-users-roles')
                || $user->hasPermission('update-users-awards')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this user.');
    }

    public function uploadArt(User $user): Response
    {
        return $user->hasPermission('update-users-art')
                ? Response::allow()
                : Response::deny('You do not have permissions to upload artwork to this user.');
    }

    public function changeRank(User $user, User $model): Response
    {
        return $user->hasPermission('update-users-rank')
                ? Response::allow()
                : Response::deny('You do not have permissions to change this user\'s faction info.');
    }

    public function changeRoles(User $user, User $model): Response
    {
        return $user->hasPermission('update-users-roles')
                && $user->isNot($model)
                ? Response::allow()
                : Response::deny('You do not have permissions to change this user\'s roles.');
    }

    public function changeAwards(User $user, User $model): Response
    {
        return $user->hasPermission('update-users-awards')
                && $user->isNot($model)
                ? Response::allow()
                : Response::deny('You do not have permissions to change this user\'s awards.');
    }

    public function delete(User $user, User $model): Response
    {
        return $user->hasPermission('delete-users')
                && $user->isNot($model)
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this user.');
    }

    public function ban(User $user, User $model): Response
    {
        return $user->hasPermission('ban-users')
                && $user->isNot($model)
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this user.');
    }
}
