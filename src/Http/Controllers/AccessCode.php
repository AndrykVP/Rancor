<?php

namespace CasWaryn\API\Http\Controllers;

use Illuminate\Http\Request;
use CasWaryn\API\Contracts\ApiRequest;

class AccessCode implements ApiRequest
{
   public function dispatch()
   {
      return 'Hello';
   }    

   public function receive()
   {
      return 'Hello';
   }
}