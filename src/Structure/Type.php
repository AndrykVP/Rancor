<?php

namespace AndrykVP\Rancor\Structure;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
   /**
    * Defines the table name
    * 
    * @var string
    */
   protected $table = 'structure_award_types';

   /**
    * Attributes available for mass assignment
    * 
    * @var array
    */
   protected $fillable = [ 'name', 'description' ];

   /**
    * Relationship to Rank model
    * 
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function awards()
   {
      return $this->hasMany('AndrykVP\Rancor\Structure\Type');
   }
}
