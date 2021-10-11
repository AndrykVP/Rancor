<?php

namespace AndrykVP\Rancor\Scanner\Notifications;

use Illuminate\Support\Facades\Http;
use AndrykVP\Rancor\Scanner\Models\Territory;

class PatrolReminder
{
   public function __invoke()
   {
      $webhook = config('rancor.discord.patrol');
      
      if($webhook != null)
      {
         $urgent = Territory::where([
            ['subscription', true],
            ['last_patrol', '<', now()->subMonths(3)],
         ])->get();

         $expired = Territory::where([
            ['subscription', true],
            ['last_patrol', '>=', now()->subMonths(3)],
            ['last_patrol', '<', now()->subMonth()],
         ])->get();

         $urgent_description = $this->buildMessage($urgent);
         $expired_description = $this->buildMessage($expired);

         return Http::post($webhook, [
            'content' => "Patrol Reminder!",
            'embeds' => [
               [
                  'title' => "Coordinates that require immediate attention",
                  'footer' => [
                     'text' => 'Last scanned over 3 months ago'
                  ],
                  'description' => $urgent_description,
                  'color' => '15158332',
               ],
               [
                  'title' => "Coordinates that should be patrolled soon",
                  'footer' => [
                     'text' => 'Last scanned between 1 and 3 months ago'
                  ],
                  'description' => $expired_description,
                  'color' => '15844367',
               ]
            ],
         ]);
      }
   }

   private function buildMessage($territories)
   {
      $message = "";

      foreach($territories as $territory)
      {
         $message = $message . "(" . $territory->x_coordinate . ", " . $territory->y_coordinate . ")\n";
      }

      return $message;
   }
}