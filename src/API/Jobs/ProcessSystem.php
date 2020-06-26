<?php

namespace AndrykVP\Rancor\API\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use AndrykVP\Rancor\Models\System;

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
        $json = file_get_contents('https://www.swcombine.com/ws/v1.0/galaxy/systems/'.$this->uid.'.json');
        $query = json_decode(str_replace('\\','',$json),TRUE);

        if(!$query)
        {
            $query = json_decode($json,TRUE);
        }

        $model = System::firstOrNew(['id' => $id]);
        $sector_id = $query['galaxy-system']['sector']['attributes']['uid'];

        $model->name = $query['galaxy-system']['name'];
        $model->x_coordinate = $query['galaxy-system']['coordinates']['galaxy']['attributes']['x'];
        $model->y_coordinate = $query['galaxy-system']['coordinates']['galaxy']['attributes']['y'];
		$model->sector_id = $sector_id ? (int)explode(':',$sector_id)[1] : null;

        $model->save();
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        Log::channel('swc')->error($exception);
    }
}
