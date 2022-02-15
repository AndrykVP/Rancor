<?php

namespace Rancor\Forums\Listeners;

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

        DB::table('forum_groupables')->insert([
            'group_id' => 1,
            'groupable_id' => $user,
            'groupable_type' => 'users',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
