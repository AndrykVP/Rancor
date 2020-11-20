<?php

namespace AndrykVP\Rancor\Forums\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class DefaultGroupUser
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $event->user->id;

        DB::table('forum_group_user')->insert([
            'user_id' => $user,
            'group_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
