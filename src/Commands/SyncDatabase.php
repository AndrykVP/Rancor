<?php

namespace AndrykVP\SWC\Commands;

use Illuminate\Console\Command;
use AndrykVP\SWC\Jobs\ProcessSector;
use AndrykVP\SWC\Jobs\ProcessSystem;
use AndrykVP\SWC\Jobs\ProcessPlanet;

class SyncDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swcsync:galaxy {resource?* : The type of resource to consume.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs the information on the database, to make sure it matches up-to-date information from Combine\'s Web Service';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {        
        $arguments = $this->argument('resource');

        // If no arguments are given. Set it to run all 3 queries
        if(empty($arguments))
        {
            $this->comment('['.now().'] All resources will be synced.');
            
            $arguments = ['sector','system','planet'];
        }

        // Run queries for each argument
        foreach($arguments as $arg)
        {
            if($arg == 'sector' || $arg == 'system' || $arg == 'planet')
            {
                $this->info('['.now().'] Adding resource "'.$arg.'" to queue. This will take a few minutes.');
                $this->apiCall($arg);
            }
            else
            {
                $this->error('['.now().'] Invalid Argument. The only acceptable ones are: "sector", "system" or "planet"');
            }
        }

        // Run the queues once all jobs have been added
        $this->info('['.now().'] Jobs from Sector resources will begin running now');
        $this->call('queue:work',['--stop-when-empty','--queue=sector,high']);

        $this->info('['.now().'] Jobs from System resources will begin running now');
        $this->call('queue:work',['--stop-when-empty','--queue=system,high']);

        $this->info('['.now().'] Jobs from Planet resources will begin running now');
        $this->call('queue:work',['--stop-when-empty','--queue=planet,high']);
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
        Log::error($exception);
    }

    /**
     * Consume Combine's Web Services for Sectors
     * 
     * @param string
     * @return array
     */
    private function apiCall($resource)
    {
        for($i = 1; $i <= 1000000; $i+=50)
        {
            $json = file_get_contents('https://www.swcombine.com/ws/v1.0/galaxy/'.$resource.'s.json?start_index='.$i);
            $query = json_decode(str_replace('\\','',$json),TRUE);

            if(!$query)
            {
                $query = json_decode($json,TRUE);
            }

            foreach($query['galaxy-'.$resource.'s'][$resource] as $entry)
            {
                if($resource == 'sector')
                {
                    ProcessSector::dispatch($entry['attributes']['uid'])->onQueue('sector');
                }
                else if($resource == 'system')
                {
                    ProcessSystem::dispatch($entry['attributes']['uid'])->onQueue('system');
                }
                else if($resource == 'planet')
                {
                    ProcessPlanet::dispatch($entry['attributes']['uid'])->onQueue('planet');
                }
            }

            if($i+50 >= $query['galaxy-'.$resource.'s']['attributes']['total'])
            {
                break;
            }
        }
    }
}
