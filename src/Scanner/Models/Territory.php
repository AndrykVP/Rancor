<?php

namespace Rancor\Scanner\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Rancor\DB\Factories\TerritoryFactory;

class Territory extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'type_id', 'subscription',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'last_patrol_at' => 'datetime',
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
	public function contributor()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	/**
	 * Set Color attribute based on the model's last_patrol_at field
	 * 
	 * @return string|null
	 */
	public function getBackgroundColorAttribute()
	{
		if($this->last_patrol_at == null) return null;

		if($this->last_patrol_at->lte(now()->subMonth())) return config('rancor.scanner.colors.warning');

		if($this->last_patrol_at->lte(now()->subMonths(3))) return config('rancor.scanner.colors.urgent');

		return config('rancor.scanner.colors.active');
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

	/**
	 * The "booted" method of the model.
	 *
	 * @return void
	 */
	protected static function booted()
	{
		static::updating(function ($territory) {
			if ($territory->isClean('updated_by')) {
				$territory->updated_by = auth()->user()->id;
			}
			if( $territory->isClean('last_patrol_at')) {
				$territory->last_patrol_at = now();
			}
		});
	}
}
