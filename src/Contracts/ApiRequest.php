<?php

namespace CasWaryn\API\Contracts;

interface ApiRequest
{
   /**
    * Function to make an outgoing request
    */
   public function dispatch();

   /**
    * Function to receive a response
    */
   public function receive();
}