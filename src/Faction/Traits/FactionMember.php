<?php

namespace AndrykVP\Rancor\Faction\Traits;

trait FactionMember
{
    /**
     * Relationship to Rank model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rank()
    {
        return $this->belongsTo('AndrykVP\Rancor\Faction\Rank');
    }
}
