<?php

namespace AndrykVP\Rancor\Audit\Listeners;

use AndrykVP\Rancor\Audit\Events\NodeUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetNodeEditor
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
     * @param  NodeUpdate  $event
     * @return void
     */
    public function handle(NodeUpdate $event)
    {
        DB::table('changelog_nodes')->insert([
            'node_id' => $event->node->id,
            'updated_by' => $this->user->id,
            'created_at' => now(),
        ]);
    }
}
