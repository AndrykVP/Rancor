<?php

namespace AndrykVP\Rancor\Forums\Observers;

use Illuminate\Support\Facades\DB;

class CategoryObserver
{
   /**
    * Handle the Category "creating" event
    *
    * @param \AndrykVP\Rancor\Forums\Models\Category  $category
    * @return void
    */
   public function creating(Category $category)
   {
      $maxLineup = DB::table('forum_categories')->max('lineup') ?? 0;
      if(is_null($category->lineup) || $category->lineup > $maxLineup + 1)
      {
         $category->lineup = $maxLineup + 1;
      }

      $lowerCategories = DB::table('forum_categories')
                        ->select('id')
                        ->where('lineup', '>=', $category->lineup)
                        ->get()
                        ->pluck('id');

      DB::table('forum_categories')
      ->whereIn('id', $lowerCategories)
      ->increment('lineup');
   }

   /**
    * Handle the Category "updating" event
    *
    * @param \AndrykVP\Rancor\Forums\Models\Category  $category
    * @return void
    */
   public function updating(Category $category)
   {
      if($category->isClean('lineup')) return;

      $maxLineup = DB::table('forum_categories')->max('lineup') ?? 0;
      if(is_null($category->lineup) || $category->lineup > $maxLineup + 1)
      {
         $category->lineup = $maxLineup + 1;
      }

      $lineupRange = [
         $category->getOriginal('lineup'), $category->lineup
      ];
      if($category->getOriginal('lineup') > $category->lineup)
      {
         $lineupRange = array_reverse($lineupRange);
      } 

      $lowerCategories = DB::table('forum_categories')
                        ->select('id')
                        ->where('id', '!=', $category->id)
                        ->whereBetween('lineup', $lineupRange)
                        ->get()
                        ->pluck('id');

      if($category->getOriginal('lineup') < $category->lineup)
      {
         DB::table('forum_categories')
         ->whereIn('id', $lowerCategories)
         ->decrement('lineup');
      } else {
         DB::table('forum_categories')
         ->whereIn('id', $lowerCategories)
         ->increment('lineup');
      }
   }

   /**
    * Handle the Category "deleted" event
    *
    * @param \AndrykVP\Rancor\Forums\Models\Category  $category
    * @return void
    */
   public function deleted(Category $category)
   {
      $lowerCategories = DB::table('forum_categories')
                        ->select('id')
                        ->where('lineup', '>', $category->lineup)
                        ->get()
                        ->pluck('id');

      DB::table('forum_categories')
      ->whereIn('id', $lowerCategories)
      ->decrement('lineup');
   }
}