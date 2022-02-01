<?php

namespace AndrykVP\Rancor\SWC\Models;

use Illuminate\Database\Eloquent\Model;
use AndrykVP\Rancor\SWC\Models\Planet;
use AndrykVP\Rancor\SWC\Models\Sector;

class System extends Model
{
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'swc_systems';

    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'id' ];
    
    /**
     * Disable auto-increments on 'id' column of the Model
     * 
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Relationship to Planet model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planets()
    {
        return $this->hasMany(Planet::class);
    }

    /**
     * Relationship to Sector model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
