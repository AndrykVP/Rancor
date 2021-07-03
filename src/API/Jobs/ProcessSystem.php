<?php

namespace AndrykVP\Rancor\API\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;
use AndrykVP\Rancor\API\Models\System;

class ProcessSystem implements ShouldQueue
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
        ])->get(`https://www.swcombine.com/ws/v2.0/galaxy/systems/{$this->uid}`)

        if($response->successful())
        {
            $query = $response->json();
            $query = $query['swcapi']['system']
    
            $model = System::firstOrNew(['id' => $id]);
            $sector_id = $query['location']['sector']['attributes']['uid'];
    
            $model->name = $query['name'];
            $model->x_coordinate = $query['location']['coordinates']['galaxy']['attributes']['x'];
            $model->y_coordinate = $query['location']['coordinates']['galaxy']['attributes']['y'];
            $model->sector_id = $sector_id ? (int)explode(':',$sector_id)[1] : null;
    
            $model->save();
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
