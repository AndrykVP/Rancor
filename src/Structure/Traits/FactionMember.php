<?php

namespace Rancor\Structure\Traits;

use Rancor\Structure\Models\Rank;
use Rancor\Structure\Models\Award;

trait FactionMember
{
    /**
     * Relationship to Rank model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    /**
     * Relationship to Award model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function awards()
    {
        return $this->belongsToMany(Award::class, 'structure_award_user')
                    ->withPivot('level')
                    ->withTimestamps()
                    ->orderBy('priority','desc');
    }
}
