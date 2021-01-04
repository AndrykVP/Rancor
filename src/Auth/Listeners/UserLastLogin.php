<?php

namespace AndrykVP\Rancor\Auth\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;

class UserLastLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        DB::table('users')
            ->where('id', $event->user->id)
            ->update(['last_login' => now()]);
    }
}
