<?php

namespace AndrykVP\Rancor\Audit\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use AndrykVP\Rancor\Audit\Events\RankChange;
use AndrykVP\Rancor\Faction\Rank;

class UserRank
{
    /**
     * Class Variable User
     * 
     * @var int
     */
    public $editor;

    /**
     * Create the event listener.
     *
     * @param  Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->editor = $request->user()->id;
    }

    /**
     * Handle the event.
     *
     * @param  RankChange  $event
     * @return void
     */
    public function handle(RankChange $event)
    {
        if($event->user->isDirty('rank_id'))
        {
            $rank_id = $event->user->getOriginal('rank_id');
            $new_rank = Rank::find($event->user->rank_id);

            if($rank_id != null)
            {
                $old_rank = Rank::find($rank_id);
    
                if($old_rank->level != $new_rank->level)
                {
                    if($old_rank->level > $new_rank->level)
                    {
                        $message = 'Demotion';
                    }
                    else if($old_rank->level < $new_rank->level)
                    {
                        $message = 'Promotion';
                    }
    
                    $message = $message . ' from ' . $old_rank->name . '(' . $old_rank->level . ') to ' . $new_rank->name . '(' . $new_rank->level . ')';
    
                    $this->createEntry($event->user->id, $message);
                }
    
                if($old_rank->department->name != $new_rank->department->name)
                {
                    $message = 'Reassigned to the ' . $new_rank->department->name . ' department';
    
                    $this->createEntry($event->user->id, $message);
                }
    
                if($old_rank->department->faction_id != $new_rank->department->faction_id)
                {
                    $message = 'Reassigned to the ' . $new_rank->department->faction->name . ' faction';
    
                    $this->createEntry($event->user->id, $message);
                }
            }
            else
            {
                $this->createEntry($event->user->id, 'Assigned the ' . $new_rank->name . ' rank');
                $this->createEntry($event->user->id, 'Assigned to the ' . $new_rank->department->name . ' department');
                $this->createEntry($event->user->id, 'Assigned to the ' . $new_rank->department->faction->name . ' faction');
            }

        }
    }

    /**
     * Create database entry.
     *
     * @param  RankChange  $event
     * @return void
     */
    private function createEntry($id, $action)
    {
        DB::table('changelog_users')->insert([
            'user_id' => $id,
            'updated_by' => $this->editor,
            'action' => $action
        ]);
    }
}
