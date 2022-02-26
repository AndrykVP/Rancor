<?php

namespace Rancor\Audit\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use App\Models\User;

class UserAwards
{
<<<<<<< HEAD
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * User model to audit
	 * 
	 * @var \App\Models\User
	 */
	public $user;

	/**
	 * Collection of awards to associate to User
	 * 
	 * @var \Illuminate\Support\Collection
	 */
	public $awards;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, Collection $awards)
	{
		$this->user = $user->load('awards');
		$this->awards = $awards;
	}
=======
   use Dispatchable, InteractsWithSockets, SerializesModels;

   public $user;
   public $awards;

   public function __construct(User $user, Array $awards)
   {
      $this->user = $user->load('awards');
      $this->awards = $awards;
   }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
