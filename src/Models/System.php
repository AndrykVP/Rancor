<?php

namespace AndrykVP\SWC\Models;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    /**
     * Attributes available for mass assignment
     */
    public $fillable = [ 'id' ];
    
    /**
     * Disable auto-increments on 'id' column of the Model
     */
    public $incrementing = false;

    /**
     * Many-to-one Relationship
     */
    public function planets()
    {
        return $this->hasMany(Planet::class);
    }

    /**
     * Inverse Relationship
     */
    public function system()
    {
        return $this->belongsTo(System::class);
    }
}
