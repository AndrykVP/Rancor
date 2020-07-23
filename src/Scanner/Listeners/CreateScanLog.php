<?php

namespace AndrykVP\Rancor\Scanner\Listeners;

use AndrykVP\Rancor\Scanner\Events\EditScan;
use AndrykVP\Rancor\Scanner\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateScanLog
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
     * @param  EditScan  $event
     * @return void
     */
    public function handle(EditScan $event)
    {
        $compare = $this->compareProps($event->new_entry,$event->old_entry);

        if($compare)
        {
            $log = new Log;
            $log->entry_id = $event->old_entry['id'];
            $log->user_id = $event->user_id;
            $log->new_type = isset($event->new_entry['type']) && $event->new_entry['type'] != $event->old_entry['type'] ? $event->new_entry['type'] : null;
            $log->old_type = isset($event->new_entry['type']) && $event->new_entry['type'] != $event->old_entry['type'] ? $event->old_entry['type'] : null;
            $log->new_name = isset($event->new_entry['name']) && $event->new_entry['name'] != $event->old_entry['name'] ? $event->new_entry['name'] : null;
            $log->old_name = isset($event->new_entry['name']) && $event->new_entry['name'] != $event->old_entry['name'] ? $event->old_entry['name'] : null;
            $log->new_owner = isset($event->new_entry['owner']) && $event->new_entry['owner'] != $event->old_entry['owner'] ? $event->new_entry['owner'] : null;
            $log->old_owner = isset($event->new_entry['owner']) && $event->new_entry['owner'] != $event->old_entry['owner'] ? $event->old_entry['owner'] : null;
            $log->new_position = isset($event->new_entry['position']) && $event->new_entry['position'] != $event->old_entry['position'] ? $event->new_entry['position'] : null;
            $log->old_position = isset($event->new_entry['position']) && $event->new_entry['position'] != $event->old_entry['position'] ? $event->old_entry['position'] : null;
            $log->recently_seen = isset($event->new_entry['last_seen']) ? $event->new_entry['last_seen']->toDateTimeString() : null;
            $log->previously_seen = isset($event->new_entry['last_seen']) ? $event->old_entry['last_seen']->toDateTimeString() : null;
            $log->updated_at = now();
            $log->save();
        }
    }

    /**
     * Private function that helps compare an updated Entry model
     * against a previously stored one in the database.
     * 
     * @param array $new
     * @param array $old
     * @return boolean
     */
    private function compareProps($new,$old)
    {
        $values = [];

        foreach($old as $key => $value)
        {
            if(isset($new[$key]) && $new[$key] != $old[$key])
            {
                $values[] = $value;
            }
        }

        if(empty($values))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}
