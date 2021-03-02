<?php

namespace AndrykVP\Rancor\Audit\Listeners;

use AndrykVP\Rancor\Audit\Events\HolocronUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NodeUpdate
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
    public function handle(HolocronUpdate $event)
    {
        $user_id = $request->user()->id;

        DB::table('changelog_nodes')->insert([
            'node_id' => $event->node->id,
            'updated_by' => $user_id,
            'created_at' => now(),
        ]);
    }
}