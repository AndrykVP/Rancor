<?php

namespace AndrykVP\Rancor\Structure\Traits;

trait FactionMember
{
    /**
     * Relationship to Rank model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rank()
    {
        return $this->belongsTo('AndrykVP\Rancor\Structure\Rank');
    }
}
