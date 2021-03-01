<?php

namespace AndrykVP\Rancor\Structure;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
   /**
    * Defines the table name
    * 
    * @var string
    */
   protected $table = 'structure_awards';

   /**
    * Attributes available for mass assignment
    * 
    * @var array
    */
   protected $fillable = [ 'class', 'name', 'description', 'code', 'levels', 'priority' ];

   /**
    * Relationship to Rank model
    * 
    * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
    */
   public function users()
   {
      return $this->belongsToMany('App\User')->withTimestamps();
   }

   /**
    * Relationship to Type model
    * 
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo
    */
    public function type()
    {
       return $this->belongsTo('AndrykVP\Rancor\Structure\Type');
    }
}
