<?php

namespace AndrykVP\Rancor\API\Models;

use Illuminate\Database\Eloquent\Model;
use AndrykVP\Rancor\API\Models\System;

class Planet extends Model
{
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'swc_planets';

    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'id', 'civilisation', 'morale', 'crime', 'tax' ];
    
    /**
     * Disable auto-increments on 'id' column of the Model
     * 
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Relationship to System model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function system()
    {
        return $this->belongsTo(System::class);
    }
}
