<?php

namespace AndrykVP\SWC\Traits;

trait FactionMember
{
    /**
     * Relationship to Rank model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rank()
    {
        return $this->belongsTo('AndrykVP\SWC\Models\Rank');
    }

    /**
     * Relationship to Permission model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany('AndrykVP\SWC\Models\Permission')->withTimestamps();
    }
}
