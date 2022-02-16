<?php

namespace Rancor\Scanner\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rancor\DB\Factories\QuadrantFactory;

class Quadrant extends Model
{
	use HasFactory;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'scanner_quadrants';

	/**
	 * Relationship to Territory model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function territories()
	{
		return $this->hasMany(Territory::class)->orderBy('y_coordinate', 'desc')->orderBy('x_coordinate', 'asc');
	}

	/**
	 * Relationship to Entry model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function entries()
	{
		return $this->hasManyThrough(Entry::class, Territory::class);
	}

	/**
	 * Create a new factory instance for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	protected static function newFactory()
	{
		return QuadrantFactory::new();
	}
}
