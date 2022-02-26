<?php

namespace Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Rancor\Audit\Enums\Access;
use Rancor\DB\Factories\IPLogFactory;
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use AndrykVP\Rancor\Audit\Enums\Access;
use AndrykVP\Rancor\DB\Factories\IPLogFactory;
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
use App\Models\User;

class IPLog extends Model
{
<<<<<<< HEAD
	use HasFactory;

	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $table = 'changelog_ips';

	
	/**
	 * Attributes available for mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [ 'user_id', 'ip_address', 'type', 'user_agent' ];

	/**
	 * Attributes that should be cast to native types
	 */
	protected $casts = [
		'type' => Access::class,
	];

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
	 * Relationship to User model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function creator()
	{
		return $this->belongsTo(User::class,'updated_by');
	}

	/**
	 * Create a new factory instance for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	protected static function newFactory()
	{
		return IPLogFactory::new();
	}
=======
   use HasFactory;

   protected $table = 'changelog_ips';

   protected $fillable = [
      'user_id',
      'ip_address',
      'type',
      'user_agent',
   ];

   protected $casts = [
      'type' => Access::class,
   ];

   public function user(): BelongsTo
   {
      return $this->belongsTo(User::class);
   }

   public function creator(): BelongsTo
   {
      return $this->belongsTo(User::class,'updated_by');
   }

   protected static function newFactory(): Factory
   {
      return IPLogFactory::new();
   }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
