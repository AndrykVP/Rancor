<?php

namespace AndrykVP\Rancor\Forums\Listeners;

use Illuminate\Support\Facades\DB;
use AndrykVP\Rancor\Forums\Events\CreateReply;

class LinkUserDiscussion
{
   /**
    * Handle the event.
    *
    * @param  CreateDiscussion  $event
    * @return void
    */
   public function handle(CreateReply $event)
   {  
      $rows = $this->createRows($event->reply->discussion_id);
      $this->updateDatabase($rows, $event->reply->discussion_id);
   }

   /**
    * Return array for Upsert
    *
    * @param int  $discussion_id
    * @return array
    */
   private function createRows(Int $discussion_id)
   {
      return DB::table('users')
      ->select('id')
      ->where('last_seen_at', '>', now()->subMonths(config('rancor.inactivity.users')))
      ->get()
      ->transform(function ($item, $key) use($discussion_id){
         return [
            'discussion_id' => $discussion_id,
            'user_id' => $item['id'],
            'created_at' => now(),
            'updated_at' => now(),
         ];
      })->toArray();
   }

   /**
    * Upserts rows and increments 'reply_count' column
    *
    * @param array  $rows
    * @param int  $discussion_id
    * @return void
    */
   private function updateDatabase(Array $rows, Int $discussion_id)
   {
      DB::table('forum_unread_discussions')
      ->upsert($rows, ['discussion_id', 'user_id'], ['updated_at']);
  
      DB::table('forum_unread_discussions')
      ->where('discussion_id', $discussion_id)
      ->increment('reply_count');
   }
}
