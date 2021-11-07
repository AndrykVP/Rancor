<?php

namespace AndrykVP\Rancor\Auth\Traits;

use Illuminate\Database\Eloquent\Builder;
use AndrykVP\Rancor\Audit\Models\BanLog;
use AndrykVP\Rancor\Auth\Models\Permission;
use AndrykVP\Rancor\Auth\Models\Role;

trait AuthRelations
{
    /**
     * Relationship to Ban model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bans()
    {
        return $this->hasMany(BanLog::class);
    }

    /**
     * Relationship to Permission model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'permissible', 'rancor_permissibles')->withTimestamps();
    }

    /**
     * Relationship to Role model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'rancor_role_user')->withTimestamps();
    }

    /**
     * Custom Function to verify existence of Permission
     * 
     * @param string  $permission
     * @return boolean
     */
    public function hasPermission(String $permission)
    {
        if($this->is_admin) return true;

        return $this->roleHasPermission($permission) || $this->userHasPermission($permission);
    }
    
    /**
     * Search for Permission through Roles
     * 
     * @param string  $permission
     * @return boolean
     */
    private function roleHasPermission(String $permission)
    {
        $this->loadMissing('roles.permissions');
        $permissions = $this->roles->pluck('permissions')->collapse()->unique();
        return $permissions->contains('name', $permission);
    }
    
    /**
     * Search for Permission through User's permissions
     * 
     * @param string  $permission
     * @return boolean
     */
    private function userHasPermission(String $permission)
    {
        $this->loadMissing('permissions');
        return $this->permissions->contains('name', $permission);
    }
}
