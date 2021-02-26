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
    if($event->entry->isDirty('type') || $event->entry->isDirty('name') || $event->entry->isDirty('owner') || $event->entry->isDirty('position'))
    {
        $log = new Log;
        $log->entry_id = $event->entry->id;
        $log->user_id = $event->entry->updated_by;
        if($event->entry->isDirty('type'))
        {
            $log->new_type = $event->entry->type;
            $log->old_type = $event->entry->getOriginal('type');
        }
        if($event->entry->isDirty('name'))
        {
            $log->new_name = $event->entry->name;
            $log->old_name = $event->entry->getOriginal('name');
        }
        if($event->entry->isDirty('owner'))
        {
            $log->new_owner = $event->entry->owner;
            $log->old_owner = $event->entry->getOriginal('owner');
        }
        if($event->entry->isDirty('position'))
        {
            $log->new_position = $event->entry->position;
            $log->old_position = $event->entry->getOriginal('position');
        }
        $log->save();
    }
}
}
