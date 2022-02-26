<?php

namespace Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Rancor\Audit\Contracts\LogContract;
use Rancor\DB\Factories\UserLogFactory;
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use AndrykVP\Rancor\Audit\Contracts\LogContract;
use AndrykVP\Rancor\DB\Factories\UserLogFactory;
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
use App\Models\User;

class UserLog extends Model implements LogContract
{
<<<<<<< HEAD
	use HasFactory;

	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $table = 'changelog_users';

	
	/**
	 * Attributes available for mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [ 'user_id', 'updated_by', 'action', 'color' ];

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
	 * Method to render Log message in views
	 * 
	 * @return string
	 */
	public function message()
	{
		$message = $this->user->name . ' ' . $this->action;
		if($this->upated_by != null)
		{
			$message = $message . ' by ' . $this->creator->name;
		}
		return $message;
	}

	/**
	 * Create a new factory instance for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	protected static function newFactory()
	{
		return UserLogFactory::new();
	}
=======
   use HasFactory;

   protected $table = 'changelog_users';

   protected $fillable = [
      'user_id',
      'updated_by',
      'action',
      'color'
   ];

   public function user(): BelongsTo
   {
      return $this->belongsTo(User::class);
   }

   public function creator(): BelongsTo
   {
      return $this->belongsTo(User::class,'updated_by');
   }

   public function message(): string
   {
      $message = $this->user->name . ' ' . $this->action;
      if($this->upated_by != null)
      {
         $message = $message . ' by ' . $this->creator->name;
      }
      return $message;
   }

   protected static function newFactory(): Factory
   {
      return UserLogFactory::new();
   }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
