<?php

namespace AndrykVP\Rancor\Scanner\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use AndrykVP\Rancor\DB\Factories\TerritoryFactory;

class Territory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'patrolled_by', 'last_patrol', 'type_id', 'subscription',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_patrol' => 'datetime',
        'subscription' => 'boolean',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scanner_territories';

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['quadrant'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['background_color'];

    /**
     * Relationship to Quadrant model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quadrant()
    {
        return $this->belongsTo(Quadrant::class);
    }

    /**
     * Relationship to TerritoryType model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function type()
    {
        return $this->belongsTo(TerritoryType::class, 'type_id');
    }

    /**
     * Relationship to Entry model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries()
    {
        return $this->hasMany(Entry::class)->latest();
    }

    /**
     * Relationship to User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patroller()
    {
        return $this->belongsTo(User::class, 'patrolled_by');
    }

    /**
     * Set Color attribute based on the model's last_patrol field
     * 
     * @return string|null
     */
    public function getBackgroundColorAttribute()
    {
        if($this->last_patrol != null)
        {
            if($this->last_patrol->lte(now()->subMonths(3)))
            {
                return 'rgba(255, 0, 0, 0.2)';
            }

            if($this->last_patrol->lte(now()->subMonth()))
            {
                return 'rgba(255, 255, 0, 0.2)';
            }

            return 'rgba(0, 255, 0, 0.2)';
        }

        return null;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TerritoryFactory::new();
    }
}
