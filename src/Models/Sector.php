<?php

namespace AndrykVP\SWC\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    /**
     * Attributes available for mass assignment
     */
    public $fillable = [ 'id', 'name'];

    /**
     * Disable auto-increments on 'id' column of the Model
     */
    public $incrementing = false;

    /**
     * Many-to-one Relationship
     */
    public function systems()
    {
        return $this->hasMany(System::class);
    }

    /**
     * Many-to-one through another relationship
     */
    public function planets()
    {
        return $this->hasManyThrough(Planet::class, System::class);
    }
}
