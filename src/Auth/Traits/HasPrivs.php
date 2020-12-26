<?php

namespace AndrykVP\Rancor\Auth\Traits;

trait HasPrivs
{
    /**
     * Relationship to Permission model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->morphToMany('AndrykVP\Rancor\Auth\Permission', 'permissible')->withTimestamps();
    }

    /**
     * Relationship to Role model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('AndrykVP\Rancor\Auth\Role')->withTimestamps();
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
            $permissions = $this->roles()->with('permissions')->get()->pluck('permissions')->collapse();

            return $permissions->contains('name', $param);
        }
        if($this->permissions()->exists())
        {
            return $this->permissions->contains('name', $param);
        }
        
        return false;
    }
}
