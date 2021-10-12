<?php

namespace AndrykVP\Rancor\Audit\Contracts;

interface LogContract
{
   /**
    * Defines a relationship to the User model that creates the Log
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo  
    */
   public function creator();

   /**
    * Defines a method to create a message to render the Log in views
    *
    * @return string
    */
   public function message();
}