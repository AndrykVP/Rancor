<?php

namespace AndrykVP\Rancor\Forums\Observers;

use Illuminate\Support\Facades\DB;

class BoardObserver
{
   /**
    * Handle the Board "creating" event
    *
    * @param \AndrykVP\Rancor\Forums\Models\Board  $board
    * @return void
    */
   public function creating(Board $board)
   {
      $maxLineup = DB::table('forum_boards')
                  ->where('category_id', $board->category_id)
                  ->max('lineup') ?? 0;
      if(is_null($board->lineup) || $board->lineup > $maxLineup + 1)
      {
         $board->lineup = $maxLineup + 1;
      }

      $lowerBoards = DB::table('forum_boards')
                        ->select('id')
                        ->where('category_id', $board->category_id)
                        ->where('lineup', '>=', $board->lineup)
                        ->get()
                        ->pluck('id');

      DB::table('forum_boards')
      ->whereIn('id', $lowerBoards)
      ->increment('lineup');
   }

   /**
    * Handle the Board "updating" event
    *
    * @param \AndrykVP\Rancor\Forums\Models\Board  $board
    * @return void
    */
   public function updating(Board $board)
   {
      if($board->isClean('lineup')) return;

      $maxLineup = DB::table('forum_boards')
                  ->where('category_id', $board->category_id)
                  ->max('lineup') ?? 0;
      if(is_null($board->lineup) || $board->lineup > $maxLineup + 1)
      {
         $board->lineup = $maxLineup + 1;
      }

      $lineupRange = [
         $board->getOriginal('lineup'), $board->lineup
      ];
      if($board->getOriginal('lineup') > $board->lineup)
      {
         $lineupRange = array_reverse($lineupRange);
      } 

      $lowerBoards = DB::table('forum_boards')
                        ->select('id')
                        ->where('category_id', $board->category_id)
                        ->where('id', '!=', $board->id)
                        ->whereBetween('lineup', $lineupRange)
                        ->get()
                        ->pluck('id');

      if($board->getOriginal('lineup') < $board->lineup)
      {
         DB::table('forum_boards')
         ->whereIn('id', $lowerBoards)
         ->decrement('lineup');
      } else {
         DB::table('forum_boards')
         ->whereIn('id', $lowerBoards)
         ->increment('lineup');
      }

      if($board->isClean('category_id')) return;

      $lowerOldBoards = DB::table('forum_boards')
                        ->select('id')
                        ->where('category_id', $board->getOriginal('category_id'))
                        ->where('lineup', '>=', $board->getOriginal('lineup'))
                        ->get()
                        ->pluck('id');

      DB::table('forum_boards')
      ->whereIn('id', $lowerOldBoards)
      ->decrement('lineup');
   }

   /**
    * Handle the Board "deleted" event
    *
    * @param \AndrykVP\Rancor\Forums\Models\Board  $board
    * @return void
    */
   public function deleted(Board $board)
   {
      $lowerBoards = DB::table('forum_boards')
                        ->select('id')
                        ->where('category_id', $board->category_id)
                        ->where('lineup', '>', $board->lineup)
                        ->get()
                        ->pluck('id');

      DB::table('forum_boards')
      ->whereIn('id', $lowerBoards)
      ->decrement('lineup');
   }
}