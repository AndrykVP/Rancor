<?php
namespace Rancor\Scanner\Enums;

enum Alliance: string
{
   case NEUTRAL = "Neutral";
   case ENEMY = 'Enemy';
   case FRIEND = 'Friend';

   /**
    * Returns color based on alliance
    *
    * @return string
    */
   public function color()
   {
      return match($this) 
      {
         Alliance::NEUTRAL => 'grey',   
         Alliance::ENEMY => 'red',   
         Alliance::FRIEND => 'green',   
      };
   }
}