<?php

namespace Rancor\Scanner\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Rancor\DB\Factories\TerritoryTypeFactory;

class TerritoryType extends Model
{
    use HasFactory;
    
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TerritoryTypeFactory::new();
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'image'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scanner_territory_types';

    /**
     * Relationship to Territory model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function territories()
    {
        return $this->hasMany(Territory::class, 'type_id');
    }
}
