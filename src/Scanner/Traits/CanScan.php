<?php

namespace AndrykVP\Rancor\Scanner\Traits;

trait CanScan
{
    /**
     * Relationship to Rank model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scanlogs()
    {
        return $this->hasMany('AndrykVP\Rancor\Scanner\Log');
    }
}
