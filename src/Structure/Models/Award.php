<?php

namespace Rancor\Structure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Rancor\DB\Factories\AwardFactory;

class Award extends Model
{
   use HasFactory;
   
   /**
    * Create a new factory instance for the model.
    *
    * @return \Illuminate\Database\Eloquent\Factories\Factory
    */
   protected static function newFactory()
   {
       return AwardFactory::new();
   }
   
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
   protected $fillable = [ 'name', 'description', 'type_id', 'code', 'levels', 'priority' ];

   /**
    * Relationship to Rank model
    * 
    * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
    */
   public function users()
   {
      return $this->belongsToMany(User::class, 'structure_award_user')->withPivot('level')->withTimestamps();
   }

   /**
    * Relationship to Type model
    * 
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo
    */
    public function type()
    {
       return $this->belongsTo(AwardType::class, 'type_id');
    }
}
