<?php

namespace Rancor\Audit\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Rancor\Audit\Enums\Access;
use Rancor\Audit\Models\IPLog as Log;

class UserLoginIP
{
<<<<<<< HEAD
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
=======
   protected $ip_address;
   protected $user_agent;
   
   public function __construct(Request $request)
   {
      $this->ip_address = $request->ip();
      $this->user_agent = $request->header('User-Agent');
   }

   public function handle(Login $event): void
   {
      Log::updateOrCreate(
         ['user_id' => $event->user->id, 'ip_address' => $this->ip_address, 'type' => Access::LOGIN],
         ['user_agent' => $this->user_agent]
      );
   }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
