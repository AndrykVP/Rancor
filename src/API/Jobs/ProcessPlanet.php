<?php

namespace AndrykVP\Rancor\API\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;
use AndrykVP\Rancor\API\Models\Planet;
use AndrykVP\Rancor\API\Models\BlackHole;

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

        if($query['galaxy-planet']['type']['attributes']['value'] == 'black hole')
        {
            $model = BlackHole::firstOrNew(['id' => $id]);
        }
        else
        {
            $model = Planet::firstOrNew(['id' => $id]);
            $model->x_coordinate = array_key_exists('system',$query['galaxy-planet']['coordinates']) ? $query['galaxy-planet']['coordinates']['system']['attributes']['x'] : null;
            $model->y_coordinate = array_key_exists('system',$query['galaxy-planet']['coordinates']) ? $query['galaxy-planet']['coordinates']['system']['attributes']['y'] : null;
            $model->civilisation = array_key_exists('system',$query['galaxy-planet']['civilisation-level']) ? $query['galaxy-planet']['civilisation-level'] : null;
            $model->morale = array_key_exists('system',$query['galaxy-planet']['morale-level']) ? $query['galaxy-planet']['morale-level'] : null;
            $model->crime = array_key_exists('system',$query['galaxy-planet']['crime-level']) ? $query['galaxy-planet']['crime-level'] : null;
            $model->tax = array_key_exists('system',$query['galaxy-planet']['tax-level']) ? $query['galaxy-planet']['tax-level'] : null;
        }
        
        $model->name = $query['galaxy-planet']['name'];
        $model->system_id = array_key_exists('system',$query['galaxy-planet']['coordinates']) ? (int)explode(':',$query['galaxy-planet']['coordinates']['system']['attributes']['uid'])[1] : null;

        $model->save();
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        Log::channel('rancor')->error($exception->getMessage());
    }
}
