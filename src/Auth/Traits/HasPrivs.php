<?php

namespace AndrykVP\SWC\Auth\Traits;

trait HasPrivs
{
    /**
     * Relationship to Permission model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany('AndrykVP\SWC\Auth\Permission')->withTimestamps();
    }
}
