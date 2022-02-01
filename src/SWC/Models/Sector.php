<?php

namespace AndrykVP\Rancor\SWC\Models;

use Illuminate\Database\Eloquent\Model;
use AndrykVP\Rancor\SWC\Models\Planet;
use AndrykVP\Rancor\SWC\Models\System;

class Sector extends Model
{
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'swc_sectors';

    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'id', 'name', 'color'];

    /**
     * Disable auto-increments on 'id' column of the Model
     * 
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Relationship to System model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function systems()
    {
        return $this->hasMany(System::class);
    }

    /**
     * Relationship to Planet model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function planets()
    {
        return $this->hasManyThrough(Planet::class, System::class);
    }
}
