<?php

namespace AndrykVP\Rancor\Audit\Traits;
use App\User;
use AndrykVP\Rancor\Audit\UserLog;

trait Auditable
{
    /**
     * Relationship to AwardLog model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function award_changelog()
    {
        return $this->hasMany('AndrykVP\Rancor\Audit\AwardLog')->latest();
    }
    
    /**
     * Relationship to NodeLog model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function node_changelog()
    {
        return $this->hasMany('AndrykVP\Rancor\Audit\NodeLog')->latest();
    }
    
    /**
     * Relationship to UserLog model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_changelog()
    {
        return $this->hasMany('AndrykVP\Rancor\Audit\UserLog')->latest();
    }
}
