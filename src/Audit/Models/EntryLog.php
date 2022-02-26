<?php

namespace Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Rancor\Audit\Contracts\LogContract;
use Rancor\DB\Factories\EntryLogFactory;
use Rancor\Scanner\Enums\Alliance;
use Rancor\Scanner\Models\Entry;

class EntryLog extends Model implements LogContract
{
<<<<<<< HEAD
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'updated_by',
		'entry_id',
		'old_type',
		'old_name',
		'old_owner',
		'old_teritory_id',
		'old_alliance',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'old_alliance' => Alliance::class,
	];

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'changelog_entries';

	/**
	 * Relationship to User model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function creator()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	/**
	 * Relationship to Entry model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function entry()
	{
		return $this->belongsTo(Entry::class);
	}

	/**
	 * Method to render Log message in views
	 * 
	 * @return string
	 */
	public function message()
	{
		return "Entry #{$this->entry->entity_id} has been modified by {$this->creator->name}";
	}

	/**
	 * Create a new factory instance for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	protected static function newFactory()
	{
		return EntryLogFactory::new();
	}
=======
   use HasFactory;

   protected $table = 'changelog_entries';

   protected $fillable = [
      'updated_by',
      'entry_id',
      'old_type',
      'old_name',
      'old_owner',
      'old_teritory_id',
      'old_alliance',
   ];
   
   protected $casts = [
      'old_alliance' => Alliance::class,
   ];
   
   public function creator(): BelongsTo
   {
      return $this->belongsTo(User::class, 'updated_by');
   }

   public function entry(): BelongsTo
   {
      return $this->belongsTo(Entry::class);
   }

   public function message(): string
   {
      return 'Entry #' . $this->entry->entity_id . ' has been modified by ' . $this->creator->name;
   }

   protected static function newFactory(): Factory
   {
      return EntryLogFactory::new();
   }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
