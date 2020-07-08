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
        return true;
    }
}
