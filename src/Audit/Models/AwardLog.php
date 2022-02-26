<?php

namespace Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Rancor\Audit\Contracts\LogContract;
use Rancor\DB\Factories\AwardLogFactory;
use Rancor\Structure\Models\Award;

class AwardLog extends Model implements LogContract
{
<<<<<<< HEAD
	use HasFactory;

	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $table = 'changelog_awards';

	/**
	 * Relationship to User model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Relationship to Award model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function award()
	{
		return $this->belongsTo(Award::class);
	}

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
	 * Method to render Log message in views
	 * 
	 * @return string
	 */
	public function message()
	{
		return $this->user->name . 'has received the award "' . $this->award->name . '" from ' . $this->creator->name;
	}

	/**
	 * Create a new factory instance for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	protected static function newFactory()
	{
		return AwardLogFactory::new();
	}
=======
   use HasFactory;

   protected $table = 'changelog_awards';

   public function user(): BelongsTo
   {
      return $this->belongsTo(User::class);
   }

   public function award(): BelongsTo
   {
      return $this->belongsTo(Award::class);
   }

   public function creator(): BelongsTo
   {
      return $this->belongsTo(User::class, 'updated_by');
   }

   public function message(): string
   {
      return $this->user->name . 'has received the award "' . $this->award->name . '" from ' . $this->creator->name;
   }

   protected static function newFactory(): Factory
   {
      return AwardLogFactory::new();
   }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
