<?php

namespace AndrykVP\Rancor\Audit\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use AndrykVP\Rancor\Audit\Events\UserUpdate;
use AndrykVP\Rancor\Structure\Models\Rank;

class UserRank
{
    /**
     * Class Variable User
     * 
     * @var int
     */
    public $editor;


    /**
     * Color Variables used in front-end of user log
     * 
     * @var string
     */
    protected $warning, $info, $alert;

    /**
     * Create the event listener.
     *
     * @param  Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->editor = $request->user()->id;
        $this->warning = config('rancor.audit.warning');
        $this->info = config('rancor.audit.info');
        $this->alert = config('rancor.audit.');
    }

    /**
     * Handle the event.
     *
     * @param  UserUpdate  $event
     * @return void
     */
    public function handle(UserUpdate $event)
    {
        if($event->user->isDirty('rank_id'))
        {
            if($event->user->rank_id == null)
            {
                $this->createEntry($event->user->id, 'removed from service', $this->alert);   
            }
            else
            {
                $rank_id = $event->user->getOriginal('rank_id');
                $new_rank = Rank::with('department.faction')->find($event->user->rank_id);
    
                if($rank_id != null)
                {
                    $old_rank = Rank::with('department.faction')->find($rank_id);
        
                    if($old_rank->level != $new_rank->level)
                    {
                        if($old_rank->level > $new_rank->level)
                        {
                            $message = 'was demoted';
                        }
                        else if($old_rank->level < $new_rank->level)
                        {
                            $message = 'was promoted';
                        }
        
                        $message = $message . ' from ' . $old_rank->name . '(' . $old_rank->level . ') to ' . $new_rank->name . '(' . $new_rank->level . ')';
        
                        $this->createEntry($event->user->id, $message, $this->info);
                    }
        
                    if($old_rank->department->name != $new_rank->department->name)
                    {
                        $message = 'was reassigned to the ' . $new_rank->department->name . ' department';
        
                        $this->createEntry($event->user->id, $message, $this->info);
                    }
        
                    if($old_rank->department->faction->id != $new_rank->department->faction->id)
                    {
                        $message = 'was reassigned to the ' . $new_rank->department->faction->name . ' faction';
        
                        $this->createEntry($event->user->id, $message, $this->info);
                    }
                }
                else
                {
                    $this->createEntry($event->user->id, 'was assigned the ' . $new_rank->name . ' rank', $this->info);
                    $this->createEntry($event->user->id, 'was assigned to the ' . $new_rank->department->name . ' department', $this->info);
                    $this->createEntry($event->user->id, 'was assigned to the ' . $new_rank->department->faction->name . ' faction', $this->info);
                }
            }
        }
    }

    /**
     * Create database entry.
     *
     * @param  UserUpdate  $event
     * @return void
     */
    private function createEntry($id, $action, $color)
    {
        DB::table('changelog_users')->insert([
            'user_id' => $id,
            'updated_by' => $this->editor,
            'action' => $action,
            'color' => $color,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
