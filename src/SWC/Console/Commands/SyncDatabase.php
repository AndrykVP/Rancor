<?php

namespace Rancor\SWC\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Exception;

class SyncDatabase extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'rancor:sync
                            {type : The type of resource to consume. Such as "galaxy" or "entities"}
                            {--r|resource=* : The resource to consume. Such as "planet" or "vehicle"}
                            {--s|skip : Skips confirmations and immediately proceeds to sync}';

    /**
     * The console command description.
     */
    protected $description = 'Syncs the information from Combine\'s Web Service to the database';

    /**
     * The resources available from Combine's Web Services
     */
    protected $resources = [
        'galaxy' => ['sector', 'system', 'planet'],
        // 'entity' => ['ship', 'vehicle', 'facility'],
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $type = $this->argument('type');
        $resources = $this->option('resource');
        $confirmation = $this->option('skip');

        if(!in_array($type, array_keys($this->resources)))
        {
            $this->error('['.now().'] The type "' . $type . '" is not a valid argument. Check the the documentation for valid arguments');
            return;
        }

        if($resources != null)
        {
            $this->info('['.now().'] Sync of "' . $type . '" type will begin for the specified resources');
        }
        else
        {
            $this->warn('['.now().'] Running the command with no parameters will retrieve all resources of the specified type. This operation might take several minutes');
            if($confirmation || $this->confirm('Do you wish to continue?'))
            {
                $this->info('['.now().'] Sync of all resources from "' . $type . '" will begin');
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
        
        $this->info('['.now().'] The jobs have been added to the queue.');
        Log::channel('rancor')->info('Sync has been successfully added to the queue');
    }

    /**
     * Consume Combine's Web Services for the specified resource type
     */
    private function apiCall(String $resource, String $type): void
    {
        $parameter = $this->parseParamaters($resource, $type);
        $i = 1;
        $running = true;

        while($running)
        {
            $query = $this->sendQuery($parameter['uri'], $resource, $i);

            if($query)
            {
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
    }

    /**
     * Returns stringified parameters to use for XML attributes
     * based on the type of resource, and the resource itself
     */
    private function parseParamaters($resource, $type): array
    {
        $result = [
            'uri' => null,
            'class' => null,
        ];

        switch($type)
        {
            case 'galaxy':
                $result['uri'] = 'galaxy/'.Str::plural($resource);
            break;
            case 'entity':
                $result['uri'] = 'types/'.Str::plural($resource);
            break;
        }

        $result['class'] = 'Rancor\SWC\Jobs\Process'.ucfirst($resource);

        return $result;
    }

    /** 
     * Returns queried array from json file
     */
    private function sendQuery($uri, $resource, $index): array|bool
    {
        $uri = "https://www.swcombine.com/ws/v2.0/{$uri}";
        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->get($uri, [
            'start_index' => $index
        ]);

        if($response->successful())
        {
            $query = $response->json();
    
            $result = [
                'array' => $query['swcapi'][Str::plural($resource)][$resource],
                'total' => $query['swcapi'][Str::plural($resource)]['attributes']['total']
            ];
    
            return $result;
        }
        else
        {
            Log::channel('rancor')->warning('['.now().'] The request to '.$uri.'/?start_index='.$index.' returned an error.');
            return false;
        }
    }
}
