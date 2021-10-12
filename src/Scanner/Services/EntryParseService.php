<?php

namespace AndrykVP\Rancor\Scanner\Services;

use Illuminate\Support\Facades\File;
use AndrykVP\Rancor\Scanner\Models\Entry;
use AndrykVP\Rancor\Scanner\Models\Territory;
use App\Models\User;
use Carbon\Carbon;

class EntryParseService {

   public int $updated;
   public int $new;
   public int $unchanged;
   private User $contributor;

   /**
    * Loops over the uploaded files and inserts the XML data into the database
    * 
    * @return void
    */
   public function __invoke(Array $upload, User $user)
   {
      $this->updated = 0;
      $this->new = 0;
      $this->unchanged = 0;
      $this->contributor = $user;

      foreach($upload['scans'] as $file) $this->fileParse($file);
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
  
      $location = $scan->channel->location;
      $territory = Territory::where([
         ['x_coordinate', $location->galX],
         ['y_coordinate', $location->galY],
      ])->firstOrFail();

      $date = $scan->channel->cgt;
      $date = ($date->years*365*24*60*60) + ($date->days*24*60*60) + ($date->hours*60*60) + ($date->minutes*60) + $date->seconds + 912668400;
      
  
      foreach($scan->channel->item as $ship)
      {
         if(property_exists($ship,'entityID'))
         {
            $model = Entry::where([
               ['entity_id', $ship->entityID],
               ['type', $ship->typeName],
            ])->first();

            $new_data = $this->parseModel($ship, $location, $date, $territory);

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
            $model->alliance = $new_data['alliance'];
            $model->last_seen = $new_data['last_seen'];
            $model->updated_by = $this->contributor->id;
            $model->territory_id = $territory->id;
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
   private function parseModel($data, $location, $date, $territory)
   {
      return [
         'type' => $data->typeName,
         'name' => isset($data->name) ?  $data->name : NULL,
         'owner' => $data->ownerName,
         'position' => $this->set_position($data, $location),
         'alliance' => $this->set_iff($data->iffStatus),
         'last_seen' => Carbon::createFromTimestamp($date)
      ];
   }

   /**
    * Returns Integer Value for Entity IFF
    * 
    * @param string  $status
    * @return int
    */
   private function set_iff(String $status = 'Neutral')
   {
      $status = strtolower($status);
      if($status == 'neutral') return 0;
      if($status == 'friend') return 1;
      if($status == 'enemy') return -1;
   }

   /**
    * Returns the position array for JSON column
    *
    * @param \stdClass  $data
    * @param \stdClass  $location
    * @return array
    */
   private function set_position($data, $location)
   {
      $location = [];
      if(isset($location->surfX) && isset($location->surfY))
      {
         $location['orbit'] = [
            'x' => $location->sysX,
            'y' => $location->sysY,
         ];
         if(isset($location->groundX) && isset($location->groundY))
         {
            $location['atmosphere'] = [
               'x' => $location->surfX,
               'y' => $location->surfY,
            ];
            $location['ground'] = [
               'x' => $data->x,
               'y' => $data->y,
            ];            
         } else
         {
            $location['atmosphere'] = [
               'x' => $data->x,
               'y' => $data->y,
            ];            
         }
      } else
      {
         $location['orbit'] = [
            'x' => isset($data->x) ? $data->x : $location->sysX,
            'y' => isset($data->y) ? $data->y : $location->sysY,
         ];
      }

      return $location;
   }

   /**
    * Returns a message displaying the results from the Scanner service
    *
    * @return string
    */
   public function message()
   {
      $message = 'Scanner Entries processed with: ';
      if($this->new > 0)
      {
         $message = $message." {$this->new} new.";
      }
      if($this->updated > 0)
      {
         $message = $message." {$this->updated} updated.";
      }
      if($this->unchanged > 0)
      {
         $message = $message." {$this->unchanged} unchanged.";
      }

      return $message;
   }
}
