<?php

namespace AndrykVP\Rancor\Audit\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use AndrykVP\Rancor\Audit\Enums\Access;
use AndrykVP\Rancor\Audit\Models\IPLog as Log;

class UserLoginIP
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
		$this->user_agent = $request->user_agent();
	}

	/**
	 * Handle the event.
	 *
	 * @param  Login  $event
	 * @return void
	 */
	public function handle(Login $event)
	{
		$user_id = $event->user->id;

		Log::updateOrCreate([
			'user_id' => $user_id,
			'ip_address' => $this->ip,
			'type' => Access::LOGIN,
		], [
			'user_agent' => $this->user_agent,
		]);
	}
}
