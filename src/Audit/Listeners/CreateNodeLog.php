<?php

namespace AndrykVP\Rancor\Audit\Listeners;

use AndrykVP\Rancor\Audit\Events\NodeUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateNodeLog
{
    /**
     * Class variables
     * 
     * @var App\Models\User  $user
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
        if($event->node->isDirty('name') || $event->node->isDirty('body'))
        {
            DB::table('changelog_nodes')->insert([
                'node_id' => $event->node->id,
                'updated_by' => $this->user->id,
                'old_name' => $event->node->isDirty('name') ? $event->node->name : null,
                'old_body' => $event->node->isDirty('body') ? $event->node->body : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
