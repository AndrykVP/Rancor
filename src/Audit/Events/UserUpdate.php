<?php

namespace Rancor\Audit\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserUpdate
{
<<<<<<< HEAD
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * User model to audit
	 * 
	 * @var App\Models\User
	 */
	public $user;

	/**
	 * Trigger for IDGen module
	 * 
	 * @var boolean
	 */
	public $generateId;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, Bool $generateId)
	{
		$this->user = $user;
		$this->generateId = $generateId;
	}
=======
   use Dispatchable, InteractsWithSockets, SerializesModels;

   public $user;
   public $generateId;

   public function __construct(User $user, Bool $generateId)
   {
      $this->user = $user;
      $this->generateId = $generateId;
   }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
