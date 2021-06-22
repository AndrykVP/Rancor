<?php

namespace AndrykVP\Rancor\Structure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AndrykVP\Rancor\Database\Factories\TypeFactory;

class Type extends Model
{
   use HasFactory;
   
   /**
    * Create a new factory instance for the model.
    *
    * @return \Illuminate\Database\Eloquent\Factories\Factory
    */
   protected static function newFactory()
   {
       return TypeFactory::new();
   }
   
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
    * Relationship to Award model
    * 
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function awards()
   {
      return $this->hasMany(Award::class);
   }
}
