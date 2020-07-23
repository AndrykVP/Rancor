<?php

namespace AndrykVP\Rancor\Scanner\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Scanner\Entry;
use AndrykVP\Rancor\Scanner\Log;
use AndrykVP\Rancor\Scanner\Events\EditScan;
use AndrykVP\Rancor\Scanner\Http\Resources\EntryResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    /**
     * Construct Controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware(config('rancor.middleware'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view',Entry::class);

        $records = Entry::paginate(15);

        return EntryResource::collection($records);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Entry::class);

        if(!$request->hasFile('files'))
        {
            return response()->json([
                'message' => 'At least 1 XML file must be uploaded.',
            ],400);
        }

        $scan = $request->file('files');
        $contributor = $request->user();
        $updated = 0;
        $new = 0;
        $unchanged = 0;

        foreach($scan as $entry)
        {
            $xml = File::get($entry);
            $parse = simplexml_load_string($xml);
            $parse = json_decode(json_encode($parse));

            $date = $parse->channel->cgt;
            $date = ($date->years*365*24*60*60) + ($date->days*24*60*60) + ($date->hours*60*60) + ($date->minutes*60) + $date->seconds + 912668400;

            $location = $parse->channel->location;

            foreach($parse->channel->item as $ship)
            {
                if(property_exists($ship,'entityID'))
                {
                    $model = Entry::find($ship->entityID);
                    $new_data = $this->parseModel($ship,$location,$date);
    
                    if($model == null)
                    {
                        $model = new Entry;
                        $model->id = $ship->entityID;
                        $new += 1;
                    }
                    elseif($model != null && $model->last_seen < $new_data['last_seen'])
                    {
                        EditScan::dispatch($model->toArray(),$new_data,$contributor->id);
                        $updated += 1;
                    }
                    else
                    {
                        $unchanged += 1;
                        continue;
                    }

                    $model->type = $new_data['type'];
                    $model->name = $new_data['name'];
                    $model->owner = $new_data['owner'];
                    $model->position = $new_data['position'];
                    $model->last_seen = $new_data['last_seen'];
                    $model->updated_by = $contributor->id;
                    $model->save();

                }
            }
        }

        return response()->json([
            'updated' => $updated,
            'new' => $new,
            'unchanged' => $unchanged,
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $this->authorize('view',Entry::class);

        $record = Entry::findOrFail($id);

        return new EntryResource($record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update',Entry::class);

        $contributor = $request->user();
        $new_data = $request->all();

        $record = Entry::findOrFail($id);

        EditScan::dispatch($record->toArray(),$new_data,$contributor->id);
        
        $record->updated_by = $contributor->id;
        $record->update($new_data);    
        return response()->json([
            'message' => 'Record for '.$record->type.' "'.$record->name.'" (#'.$record->id.') has been updated.',
        ],200);
    }

    /**
     * Remove the specified Usergroup resource from storage.
     *
     * @param  \App\Title  $title
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('delete',Entry::class);

        $Entry = Entry::findOrFail($id);
        $Entry->delete();

        return response()->json([
            'message' => 'All records of the Entry "'.$Entry->name.'" (#'.$Entry->id.') have been successfully deleted.'
        ],200);
    }

    /**
     * Search specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('view',Entry::class);

        $param = $request->parameter;
        $record = Entry::where('id',$param)
                        ->orWhere('type','like','%'.$param.'%')
                        ->orWhere('owner','like','%'.$param.'%')
                        ->paginate(15);

        return EntryResource::collection($record);
    }

    /**
     * Parse input data from XML into a PHP array
     * 
     * @param array $data
     * @param array $location
     * @param int $date
     * @return array
     */
    private function parseModel($data,$location,$date)
    {
        return [
            'type' => $data->typeName,
            'name' => isset($data->name) ?  $data->name : NULL,
            'owner' => $data->ownerName,
            'position' => [
                'galaxy' => [
                    'x' => $location->galX,
                    'y' => $location->galY,
                ],
                'system' => [
                    'x' => isset($location->surfX) ? $location->sysX : ( isset($data->x) ? $data->x : $location->sysX ),
                    'y' => isset($location->surfY) ? $location->sysY : ( isset($data->y) ? $data->y : $location->sysY ),
                ],
                'surface' => [
                    'x' => isset($location->surfX) ? ( isset($location->groundX) ? $location->surfX : $data->x ) : NULL,
                    'y' => isset($location->surfY) ? ( isset($location->groundY) ? $location->surfY : $data->y ) : NULL,
                ],
                'ground' => [
                    'x' => isset($location->groundX) ? $data->x : NULL,
                    'y' => isset($location->groundY) ? $data->y : NULL,
                ],
            ],
            'last_seen' => Carbon::createFromTimestamp($date)
        ];
    }
}
