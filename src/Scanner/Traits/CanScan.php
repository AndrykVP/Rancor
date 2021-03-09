<?php

namespace AndrykVP\Rancor\Scanner\Traits;

use AndrykVP\Rancor\Scanner\Models\Log;

trait CanScan
{
    /**
     * Relationship to Rank model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scanlogs()
    {
        return $this->hasMany(Log::class);
    }
}
