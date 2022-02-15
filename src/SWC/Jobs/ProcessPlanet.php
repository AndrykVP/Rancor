<?php

namespace Rancor\SWC\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;
use Rancor\SWC\Models\Planet;
// use Rancor\SWC\Models\BlackHole;

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
        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->get(`https://www.swcombine.com/ws/v2.0/galaxy/planets/{$this->uid}`);

        if($response->successful())
        {
            $query = $response->json();
            $query = $query['swcapi']['planet'];
            // if($query['galaxy-planet']['type']['attributes']['value'] == 'black hole')
            // {
            //     $model = BlackHole::firstOrNew(['id' => $id]);
            // }
            // else
            // {
                $model = Planet::firstOrNew(['id' => $id]);
                $model->x_coordinate = array_key_exists('system',$query['location']['coordinates']) ? $query['location']['coordinates']['system']['attributes']['x'] : null;
                $model->y_coordinate = array_key_exists('system',$query['location']['coordinates']) ? $query['location']['coordinates']['system']['attributes']['y'] : null;
                $model->population = array_key_exists('population',$query) ? $query['population'] : null;
                $model->civilisation = array_key_exists('civilisationlevel',$query) ? $query['civilisationlevel'] : null;
                $model->morale = array_key_exists('moralelevel',$query) ? $query['moralelevel'] : null;
                $model->crime = array_key_exists('crimelevel',$query) ? $query['crimelevel'] : null;
                $model->tax = array_key_exists('taxlevel',$query) ? $query['taxlevel'] : null;
            // }
            
            $model->name = $query['name'];
            $model->system_id = array_key_exists('system',$query['location']) ? (int)explode(':',$query['location']['system']['attributes']['uid'])[1] : null;
    
            $model->save();
        }
        else {
            $this->fail();
        }

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
