<?php

namespace AndrykVP\SWC\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use AndrykVP\SWC\Models\Planet;

class ProcessPlanet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $uid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $id = (int)explode(':',$this->uid)[1];
        $json = file_get_contents('https://www.swcombine.com/ws/v1.0/galaxy/planets/'.$this->uid.'.json');
        $query = json_decode(str_replace('\\','',$json),TRUE);

        if(!$query)
        {
            $query = json_decode($json,TRUE);
        }

        $model = Planet::firstOrNew(['id' => $id]);
        $system_id = $query['galaxy-planet']['system']['attributes']['uid'];

        $model->name = $query['galaxy-planet']['name'];
        $model->x_coordinate = $query['galaxy-planet']['coordinates']['system']['attributes']['x'];
        $model->y_coordinate = $query['galaxy-planet']['coordinates']['system']['attributes']['y'];
        $model->system_id = $system_id ? (int)explode(':',$system_id)[1] : null;

        $model->save();
    }
}
