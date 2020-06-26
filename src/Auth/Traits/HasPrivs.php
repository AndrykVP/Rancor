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
        return $this->belongsToMany('AndrykVP\Rancor\Auth\Permission')->withTimestamps();
    }
}
