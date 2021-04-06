<?php

namespace AndrykVP\Rancor\API\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;
use AndrykVP\Rancor\API\Models\Sector;

class ProcessSector implements ShouldQueue
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
        $json = file_get_contents('https://www.swcombine.com/ws/v1.0/galaxy/sectors/'.$this->uid.'.json');
        $query = json_decode(str_replace('\\','',$json),TRUE);

        $model = Sector::firstOrNew(['id' => $id]);
        $model->name = $query['galaxy-sector']['name'];
        $model->save();
    }

    /**
     * The job failed to process.
     *
     * @param  Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        Log::channel('rancor')->error($exception->getMessage());
    }
}
