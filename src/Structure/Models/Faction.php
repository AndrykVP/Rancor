<?php

namespace AndrykVP\Rancor\Structure;

use Illuminate\Database\Eloquent\Model;
use AndrykVP\Rancor\Database\Factories\FactionFactory;
use AndrykVP\Rancor\Structure\Models\Rank;
use AndrykVP\Rancor\Structure\Models\Department;

class Faction extends Model
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return FactionFactory::new();
    }
    
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'structure_factions';

    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'name' ];

    /**
     * Relationship to Department model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Relationship to Rank model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function ranks()
    {
        return $this->hasManyThrough(Rank::class, Department::class);
    }
}
