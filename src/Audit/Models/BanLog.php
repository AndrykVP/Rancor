<?php

namespace Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Rancor\Audit\Contracts\LogContract;
use Rancor\DB\Factories\BanLogFactory;
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use AndrykVP\Rancor\Audit\Contracts\LogContract;
use AndrykVP\Rancor\DB\Factories\BanLogFactory;
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
use App\Models\User;

class BanLog extends Model implements LogContract
{
<<<<<<< HEAD
	use HasFactory;
	
	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $table = 'changelog_bans';

	/**
	 * Attributes available for mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [ 'user_id', 'updated_by', 'status', 'reason'];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'status' => 'boolean',
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
		return $this->belongsTo(User::class, 'updated_by');
	}

	/**
	 * Method to render Log message in views
	 * 
	 * @return string
	 */
	public function message()
	{
		return $this->user->name . 'has been ' . ($this->status ? 'banned' : 'unbanned') . ' by ' . $this->creator->name . ' with reason: ' . $this->reason;
	}

	/**
	 * Create a new factory instance for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	protected static function newFactory()
	{
		return BanLogFactory::new();
	}
=======
   use HasFactory;
   
   protected $table = 'changelog_bans';

   protected $fillable = [ 'user_id', 'updated_by', 'status', 'reason'];

   protected $casts = [
      'status' => 'boolean',
   ];

   public function user(): BelongsTo
   {
      return $this->belongsTo(User::class);
   }

   public function creator(): BelongsTo
   {
      return $this->belongsTo(User::class, 'updated_by');
   }

   public function message(): string
   {
      return $this->user->name . 'has been ' . ($this->status ? 'banned' : 'unbanned') . ' by ' . $this->creator->name . ' with reason: ' . $this->reason;
   }

   protected static function newFactory(): Factory
   {
      return BanLogFactory::new();
   }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
