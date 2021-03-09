<?php

namespace AndrykVP\Rancor\Structure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use AndrykVP\Rancor\Database\Factories\RankFactory;
use AndrykVP\Rancor\Structure\Models\Department;

class Rank extends Model
{
    use HasFactory;
    
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return RankFactory::new();
    }
    
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'structure_ranks';

    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'name', 'description', 'department_id', 'level' ];

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relationship to Department model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
