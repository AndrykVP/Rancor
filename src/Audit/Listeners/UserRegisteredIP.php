<?php

namespace AndrykVP\Rancor\Audit\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use AndrykVP\Rancor\Audit\Enums\Access;

class UserRegisteredIP
{
    /**
     * Class variables
     * 
     * @var Request $request
     */
    protected $request;

    /**
     * Create the event listener.
     *
     * @param  Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user_id = $event->user->id;
        $ip = $this->request->ip();
        $ua = $this->request->header('User-Agent');

        DB::table('changelog_ips')->insert([
            'user_id' => $user_id,
            'ip_address' => $ip,
            'user_agent' => $ua,
            'type' => Access::REGISTRATION,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('changelog_users')->insert([
            'user_id' => $user_id,
            'action' => 'registered a new account',
            'color' => 'yellow',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
