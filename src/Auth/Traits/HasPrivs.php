<?php

namespace AndrykVP\Rancor\Auth\Traits;

use AndrykVP\Rancor\Auth\Models\Permission;
use AndrykVP\Rancor\Auth\Models\Role;

trait HasPrivs
{
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
     * @return boolean
     */
    public function hasPermission($param)
    {
        if($this->is_admin) return true;

        if($this->roles()->exists())
        {
            $permissions = $this->roles()->with('permissions')->get()->pluck('permissions')->collapse()->merge($this->permissions)->unique();

            return $permissions->contains('name', $param);
        }
        if($this->permissions()->exists())
        {
            return $this->permissions->contains('name', $param);
        }
        
        return false;
    }
}
