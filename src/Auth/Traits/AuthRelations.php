<?php

namespace AndrykVP\Rancor\Auth\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use AndrykVP\Rancor\Audit\Models\BanLog;
use AndrykVP\Rancor\Auth\Models\Permission;
use AndrykVP\Rancor\Auth\Models\Role;

trait AuthRelations
{
    public function bans(): HasMany
    {
        return $this->hasMany(BanLog::class);
    }

    public function permissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'permissible', 'rancor_permissibles')->withTimestamps();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'rancor_role_user')->withTimestamps();
    }

    public function hasPermission(String $permission): bool
    {
        if($this->is_admin) return true;

        return $this->roleHasPermission($permission) || $this->userHasPermission($permission);
    }
    
    private function roleHasPermission(String $permission): bool
    {
        $this->loadMissing('roles.permissions');
        $permissions = $this->roles->pluck('permissions')->collapse()->unique();
        return $permissions->contains('name', $permission);
    }
    
    private function userHasPermission(String $permission): bool
    {
        $this->loadMissing('permissions');
        return $this->permissions->contains('name', $permission);
    }
}
