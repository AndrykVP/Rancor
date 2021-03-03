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

    /**
     * Relationship to Award model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function awards()
    {
        return $this->belongsToMany('AndrykVP\Rancor\Structure\Award', 'structure_award_user')->withPivot('level')->withTimestamps()->orderBy('priority','desc');
    }
}
