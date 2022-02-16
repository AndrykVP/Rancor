<?php

namespace Rancor\Scanner\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rancor\Audit\Models\EntryLog;
use Rancor\Audit\Events\EntryUpdate;
use Rancor\DB\Factories\EntryFactory;
use Rancor\Scanner\Enums\Alliance;

class Entry extends Model
{
	use HasFactory;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'entity_id', 'type', 'name', 'owner', 'position', 'alliance', 'last_seen', 'updated_by'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'updated_by'
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'position' => 'array',
		'last_seen' => 'datetime',
		'alliance' => Alliance::class,
	];

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'scanner_entries';

	/**
	 * Registers custom events for the model.
	 * 
	 * @var array
	 */
	protected $dispatchesEvents = [
		'updating' => EntryUpdate::class,
	];

	/**
	 * Relationship to Log model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function changelog()
	{
		return $this->hasMany(EntryLog::class)->latest();
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
	 * Relationship to Territory model
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function territory()
	{
		return $this->belongsTo(Territory::class);
	}
	
	/**
	 * Create a new factory instance for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	protected static function newFactory()
	{
		return EntryFactory::new();
	}
}
