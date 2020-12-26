<?php

namespace AndrykVP\Rancor\Audit\Traits;
use App\User;
use AndrykVP\Rancor\Audit\UserLog;

trait Auditable
{
    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function changelog()
    {
        return $this->hasMany('AndrykVP\Rancor\Audit\UserLog')->latest();
    }
}
