<?php

namespace AndrykVP\Rancor\Scanner;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'entry_id', 'old_type', 'new_type', 'old_name', 'new_name', 'old_owner', 'new_owner', 'old_position', 'new_position'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'old_position' => 'array',
        'new_position' => 'array',
    ];

    /**
     * The attributes that should be cast to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
    ];

    /**
     * Deactivating timestamp tables.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scanner_logs';

    /**
     * Enable only 'created_at' column
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contributor()
    {
        return $this->belongsTo('App\User','user_id');
    }

    /**
     * Relationship to Entry model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo('AndrykVP\Rancor\Scanner\Entry');
    }
}
