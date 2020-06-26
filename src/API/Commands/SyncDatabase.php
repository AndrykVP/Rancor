<?php

namespace AndrykVP\SWC\API\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
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
    protected $signature = 'swc:sync
                            {--galaxy=* : The type of galaxy resource to consume.}
                            {--entities=* : The type of galaxy resource to consume.}';

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
     * @return void
     */
    public function handle()
    {        
        Log::channel('swc')->notice('['.now().'] Sync has begun');

        $options = [];

        foreach($this->options() as $option => $args)
        {
            if($option == 'galaxy' && $args != null || $option == 'entities' && $args != null)
            {
                $this->info('Adding '.$option.' to array');
                $options[$option] = $args;
            }
        }

        if(!$options)
        {
            $this->info('No options given');
        }
        else
        {
            $this->info('Arguments given');
        }

        /*
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
                return;
            }
        }

        // Run jobs for each argument
        $this->info('['.now().'] Queued jobs will begin running now');
        $this->call('queue:work',['--stop-when-empty', '--queue' => implode(',',$arguments)]);
        

        // Log end of command
        Log::channel('swc')->notice('['.now().'] Sync has completed successfully');
        return;
        */
    }

    /**
     * Consume Combine's Web Services for Sectors
     * 
     * @param string
     * @return void
     */
    private function apiCall($resource)
    {
        $i = 1;
        $running = true;

        while($running)
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
                $running = false;
            }

            $i += 50;
        }
    }
}
