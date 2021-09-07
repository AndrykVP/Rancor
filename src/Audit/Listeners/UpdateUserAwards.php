<?php

namespace AndrykVP\Rancor\Audit\Listeners;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use AndrykVP\Rancor\Audit\Events\UserAwards;

class UpdateUserAwards
{
   /**
    * Class variables
    * 
    * @var App\Models\User  $admin
    */
   protected $admin;

   /**
    * Create the event listener.
    *
    * @param  Request  $request
    * @return void
    */
   public function __construct(Request $request)
   {
      $this->admin = $request->user();
   }

   /**
    * Handle the event.
    *
    * @param  UserAward  $event
    * @return void
    */
   public function handle(UserAwards $event)
   {
      $data = $this->makeLogTable($event->user, $event->awards);
      if($data->isNotEmpty())
      {
         DB::table('changelog_awards')->insert($data->toArray());
      }
   }

   /**
    * Create Array to Insert to Database
    * 
    * @param App\Modes\User $event
    * @return array
    */
   private function makeLogTable(User $user, Array $awards)
   {
      $data = collect([]);
      foreach($awards as $awardId => $level)
      {
         $existing_award = $user->awards->firstWhere('id', $awardId);
         $change = $this->getAction($existing_award, $level['level']);
         
         if($change != 0)
         {
            $data->push([
               'award_id' => $awardId,
               'user_id' => $user->id,
               'action' => $change,
               'updated_by' => $this->admin->id,
               'created_at' => now(),
               'updated_at' => now(),
            ]);
         }
      }

      foreach($user->awards as $award)
      {
         if(!array_key_exists($award->id, $awards))
         {
            $data->push([
               'award_id' => $award->id,
               'user_id' => $user->id,
               'action' => (- $award->pivot->level),
               'updated_by' => $this->admin->id,
               'created_at' => now(),
               'updated_at' => now(),
            ]);
         }
      }
      return $data;
   }

   /**
    * Return Integer difference between new Award and Old Award
    * 
    * @param null|object  $award
    * @param integer  $level
    */
   private function getAction(Null|Object $award, Int $level)
   {
      if($award == null) return $level;

      return $level - $award->pivot->level;
   }
}
