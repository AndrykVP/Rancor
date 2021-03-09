<?php

namespace AndrykVP\Rancor\Audit\Traits;

use App\Models\User;
use AndrykVP\Rancor\Audit\Models\AwardLog;
use AndrykVP\Rancor\Audit\Models\NodeLog;
use AndrykVP\Rancor\Audit\Models\UserLog;

trait Auditable
{
    /**
     * Relationship to AwardLog model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function awardLog()
    {
        return $this->hasMany(AwardLog::class)->latest();
    }
    
    /**
     * Relationship to NodeLog model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nodeLog()
    {
        return $this->hasMany(NodeLog::class)->latest();
    }
    
    /**
     * Relationship to UserLog model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userLog()
    {
        return $this->hasMany(UserLog::class)->latest();
    }
}
