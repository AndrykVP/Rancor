<?php

namespace AndrykVP\Rancor\Forums\Observers;

use Illuminate\Support\Facades\DB;
use AndrykVP\Rancor\Forums\Models\Category;

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
                        ->pluck('id')
                        ->toArray();

      $this->increment_lineup($lowerCategories);
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

      $maxLineup = DB::table('forum_categories')
                  ->where('id', '!=', $category->id)
                  ->max('lineup') ?? 0;
      if(is_null($category->lineup) || $category->lineup > ($maxLineup + 1))
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
                        ->pluck('id')
                        ->toArray();

      if($category->getOriginal('lineup') < $category->lineup) $this->decrement_lineup($lowerCategories);
      else $this->increment_lineup($lowerCategories);
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
                        ->pluck('id')
                        ->toArray();

      $this->decrement_lineup($lowerCategories);
   }

   /**
    * Function to increment Category lineup in case of addition
    *
    * @param array  $category_ids
    */
   private function increment_lineup(Array $category_ids)
   {
      DB::table('forum_categories')
      ->whereIn('id', $category_ids)
      ->increment('lineup');
   }

   /**
    * Function to decrement Category lineup in case of removal
    *
    * @param array  $category_ids
    */
   private function decrement_lineup(Array $category_ids)
   {
      DB::table('forum_categories')
      ->whereIn('id', $category_ids)
      ->decrement('lineup');
   }
}