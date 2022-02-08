<?php

namespace AndrykVP\Rancor\Audit\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface LogContract
{
   /**
    * Defines a relationship to the User model that creates the Log
    */
   public function creator(): BelongsTo;

   /**
    * Defines a method to create a message to render the Log in views
    */
   public function message(): string;
}