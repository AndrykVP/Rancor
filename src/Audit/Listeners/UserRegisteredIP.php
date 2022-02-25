<?php

namespace Rancor\Audit\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rancor\Audit\Enums\Access;

class UserRegisteredIP
{
	/**
	 * IP of the user accessing the app
	 * 
	 * @var string
	 */
	protected $ip;

	/**
	 * Browser name of the user accessing the app
	 * 
	 * @var string
	 */
	protected $user_agent;

	/**
	 * Create the event listener.
	 *
	 * @param  Request  $request
	 * @return void
	 */
	public function __construct(Request $request)
	{
		$this->ip = $request->ip();
		$this->user_agent = $request->header('User-Agent');
	}

	/**
	 * Handle the event.
	 *
	 * @param  Registered  $event
	 * @return void
	 */
	public function handle(Registered $event)
	{
		DB::table('changelog_ips')->insert([
			'user_id' => $event->user->id,
			'ip_address' => $this->ip,
			'user_agent' => $this->user_agent,
			'type' => Access::REGISTRATION,
			'created_at' => now(),
			'updated_at' => now(),
		]);

		DB::table('changelog_users')->insert([
			'user_id' => $event->user->id,
			'action' => 'registered a new account',
			'color' => 'yellow',
			'created_at' => now(),
			'updated_at' => now(),
		]);
	}
}
