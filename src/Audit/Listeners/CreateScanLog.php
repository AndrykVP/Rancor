<?php

namespace AndrykVP\Rancor\Audit\Listeners;

use AndrykVP\Rancor\Audit\Events\EntryUpdate;
use AndrykVP\Rancor\Audit\Models\EntryLog;
use Illuminate\Http\Request;

class CreateScanLog
{
    public $contributor;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->contributor = $request->user()->id;
    }

    /**
     * Handle the event.
     *
     * @param  EntryUpdate  $event
     * @return void
     */
public function handle(EntryUpdate $event)
{
    if($event->entry->isDirty('type')
    || $event->entry->isDirty('name')
    || $event->entry->isDirty('owner') 
    || $event->entry->isDirty('alliance')
    || $event->entry->isDirty('territory_id'))
    {
        $log = new EntryLog;
        $log->entry_id = $event->entry->id;
        $log->updated_by = $this->contributor;
        if($event->entry->isDirty('type'))
        {
            $log->old_type = $event->entry->getOriginal('type');
        }
        if($event->entry->isDirty('name'))
        {
            $log->old_name = $event->entry->getOriginal('name');
        }
        if($event->entry->isDirty('owner'))
        {
            $log->old_owner = $event->entry->getOriginal('owner');
        }
        if($event->entry->isDirty('alliance'))
        {
            $log->old_alliance = $event->entry->getOriginal('alliance');
        }
        if($event->entry->isDirty('territory_id'))
        {
            $log->old_territory_id = $event->entry->getOriginal('territory_id');
        }
        $log->save();
    }
}
}
