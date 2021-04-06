<?php

namespace AndrykVP\Rancor\API\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Exception;

class SyncDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rancor:sync
                            {type : The type of resource to consume. Such as "galaxy" or "entities"}
                            {--r|resource=* : The resource to consume. Such as "planet" or "vehicle"}
                            {--s|skip : Skips confirmations and immediately proceeds to sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs the galaxy information from Combine\'s Web Service to the database';

    /**
     * The resources available from Combine's Web Services
     * 
     * @var array
     */
    protected $resources = [
        'galaxy' => ['sector','system','planet'],
        //'entity' => ['ship', 'vehicle'],
    ];

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
        $type = $this->argument('type');
        $resources = $this->option('resource');
        $confirmation = $this->option('skip');

        if(!in_array($type,array_keys($this->resources)))
        {
            $this->error('['.now().'] The type "'.$type.'" is not a valid argument. Check the the documentation for valid arguments');
            return;
        }

        if($resources)
        {
            $this->info('['.now().'] Sync of "'.$type.'" type will begin for the specified resources');
        }
        else
        {
            $this->warn('['.now().'] Running the command with no parameters will retrieve all resources of the specified type. This operation might take several minutes');
            if($confirmation || $this->confirm('Do you wish to continue?'))
            {
                $this->info('['.now().'] Sync of all resources from "'.$type.'" will begin');
                $resources = $this->resources[$type];
            }
            else
            {
                return;
            }
        }

        Log::channel('rancor')->notice('Galaxy sync has been triggered');

        // Run queries for each argument
        foreach($resources as $arg)
        {
            if(in_array($arg,$this->resources[$type]))
            {
                $this->comment('['.now().'] Adding resource "'.$arg.'" to queue. This will take a few minutes.');
                $this->apiCall($arg,$type);
            }
            else
            {
                $this->warn('Invalid Argument "'.$arg.'" was skipped');
            }
        }
        
        $this->info('['.now().'] The jobs have been added to the queue. Running the queue will take several minutes');

        if($confirmation || $this->confirm('Do you wish to continue?'))
        {
            Log::channel('rancor')->warning('The queued jobs to sync galaxy have begun to run. This process might take several minutes');

            // Run jobs for each argument
            $this->comment('Queued jobs will begin running now');
            $this->call('queue:work',['--stop-when-empty' => 1, '--queue' => implode(',',$resources)]);
            
    
            // Log end of command
            Log::channel('rancor')->info('Sync has completed successfully');
            return;
        }
        else
        {
            Log::channel('rancor')->warning('The sync was incomplete because the queue was not run. If you wish to complete the sync, run the artisan commands.');
            $this->warn('The jobs were not dispatched therefore the database was not synced. In order to complete the sync run the artisan commands');
            return;
        }
    }

    /**
     * Consume Combine's Web Services for Sectors
     * 
     * @param string
     * @return void
     */
    private function apiCall($resource, $type)
    {
        $parameter = $this->parseParamaters($resource, $type);
        $i = 1;
        $running = true;

        while($running)
        {
            $query = $this->sendQuery($parameter['uri'], $type, $resource, $i);

            foreach($query['array'] as $entry)
            {
                $parameter['class']::dispatch($entry['attributes']['uid'])->onQueue($resource);
            }

            if($i+50 >= $query['total'])
            {
                $running = false;
            }

            $i += 50;
        }
    }

    /**
     * Returns stringified parameters to use for XML attributes
     * based on the type of resource, and the resource itself
     * 
     * @return array
     */
    private function parseParamaters($res, $type)
    {
        $result = [
            'uri' => null,
            'class' => null,
        ];

        switch($type)
        {
            case 'galaxy':
                $result['uri'] = 'galaxy/'.$res.'s';
            break;
            case 'entity':
                $result['uri'] = 'types/'.$res.'s';
            break;
        }

        $result['class'] = 'AndrykVP\Rancor\API\Jobs\Process'.ucfirst($res);

        return $result;
    }

    /** 
     * Returns queried array from json file
     * 
     * @return array
     */
    private function sendQuery($uri, $type, $res, $i)
    {
        $json = file_get_contents('https://www.swcombine.com/ws/v1.0/'.$uri.'.json?start_index='.$i);
        $query = json_decode(str_replace('\\','',$json),TRUE);

        if(!$query)
        {
            $query = json_decode($json,TRUE);
        }

        $result = [
            'array' => [],
            'total' => null
        ];

        switch($type)
        {
            case 'galaxy':
                $result = [
                    'array' => $query['galaxy-'.$res.'s'][$res],
                    'total' => $query['galaxy-'.$res.'s']['attributes']['total'],
                ];
            break;
            case 'entity':
                $result = [
                    'array' => $query['types-entities']['types']['type'],
                    'total' => $query['types-entities']['types']['attributes']['total'],
                ];
            break;
        }

        return $result;
    }
}
