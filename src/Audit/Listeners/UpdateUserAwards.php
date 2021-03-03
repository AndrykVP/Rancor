<?php

namespace AndrykVP\Rancor\Audit\Listeners;

use AndrykVP\Rancor\Audit\Events\UserAward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateUserAward
{
    /**
     * Class variables
     * 
     * @var App\User  $user
     */
    protected $user;

    /**
     * Create the event listener.
     *
     * @param  Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->user = $request->user();
    }

    /**
     * Handle the event.
     *
     * @param  UserAward  $event
     * @return void
     */
    public function handle(UserAward $event)
    {
        DB::table('changelog_nodes')->insert([
            'award_id' => $event->node->id,
            'action' => $event->action,
            'updated_by' => $this->user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
