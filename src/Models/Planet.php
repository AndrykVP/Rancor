<?php

namespace AndrykVP\SWC\Models;

use Illuminate\Database\Eloquent\Model;

class Planet extends Model
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
     * Inverse Relationship
     */
    public function system()
    {
        return $this->belongsTo(System::class);
    }
}
