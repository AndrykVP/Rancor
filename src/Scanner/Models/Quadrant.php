<?php

namespace AndrykVP\Rancor\Scanner\Models;

use Illuminate\Database\Eloquent\Model;

class Quadrant extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scanner_quadrants';

    /**
     * Relationship to Territory model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function territories()
    {
        return $this->hasMany(Territory::class);
    }

    /**
     * Relationship to Entry model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries()
    {
        return $this->hasManyThrough(Entry::class, Territory::class);
    }
}
