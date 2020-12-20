<?php

namespace AndrykVP\Rancor\Scanner\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use AndrykVP\Rancor\Scanner\Entry;
use Carbon\Carbon;

class EntryParseService {

   public $updated = 0;
   public $new = 0;
   public $unchanged = 0;
   public $contributor;
   private $files;

   /**
    * Construct Service
    * 
    * @return void
    */
   public function __construct(Request $request)
   {
      $this->contributor = $request->user();
      $this->files = $request->file('files');
   }

   /**
    * Checks if the uploaded files are an array or a file object
    * and inserts the XML data into the database.
    *
    * @return void
    */
   public function start()
   {
      if(is_array($this->files))
      {
         foreach($this->files as $file)
         {
            $scan = $this->fileParse($file);
         }
      }
      else
      {
         $scan = $this->fileParse($this->files);     
      }
   }

   /**
    * Creates or Updates the model for each entry in the XML file
    * and counts the number of updated, new and unchanged models.
    *
    * @param File  $file;
    * @return void;
    */
   private function fileParse($file)
   {
      $xml = File::get($file);
      $scan = simplexml_load_string($xml);
      $scan = json_decode(json_encode($scan));
  
      $date = $scan->channel->cgt;
      $date = ($date->years*365*24*60*60) + ($date->days*24*60*60) + ($date->hours*60*60) + ($date->minutes*60) + $date->seconds + 912668400;
  
      $location = $scan->channel->location;
  
      foreach($scan->channel->item as $ship)
      {
         if(property_exists($ship,'entityID'))
         {
            $model = Entry::where([
               ['entity_id',$ship->entityID],
               ['type',$ship->typeName],
            ])->first();

            $new_data = $this->parseModel($ship,$location,$date);

            if($model == null)
            {
               $model = new Entry;
               $model->entity_id = $ship->entityID;
               $this->new += 1;
            }
            elseif($model != null && $model->last_seen < $new_data['last_seen'])
            {
               $this->updated += 1;
            }
            else
            {
               $this->unchanged += 1;
               continue;
            }

            $model->type = $new_data['type'];
            $model->name = strip_tags($new_data['name']);
            $model->owner = $new_data['owner'];
            $model->position = $new_data['position'];
            $model->last_seen = $new_data['last_seen'];
            $model->updated_by = $this->contributor->id;
            $model->save();
         }
      }
   }

   /**
    * Parses input data from XML into a PHP array
    * 
    * @param \stdClass  $data
    * @param \stdClass  $location
    * @param int  $date
    * @return array
    */
   private function parseModel($data, $location, $date)
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
