<?php

namespace Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rancor\Audit\Enums\Access;
use Rancor\DB\Factories\IPLogFactory;
use App\Models\User;

class IPLog extends Model
{
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
}
