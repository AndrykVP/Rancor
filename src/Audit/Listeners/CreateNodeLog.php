<?php

namespace AndrykVP\Rancor\Audit\Listeners;

use AndrykVP\Rancor\Audit\Events\NodeUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateNodeLog
{
    protected $user;

    public function __construct(Request $request)
    {
        $this->user = $request->user();
    }

    public function handle(NodeUpdate $event): void
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
