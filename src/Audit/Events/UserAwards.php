<?php

namespace Rancor\Audit\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use App\Models\User;

class UserAwards
{
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
}
