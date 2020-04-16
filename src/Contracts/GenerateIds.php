<?php

namespace CasWaryn\IDGen\Contracts;

interface GenerateIds
{
   /**
    * Funtion to build the avatar images
    *
    * @return void
    */
   public function makeAvatar();

   /**
    * Funtion to build the signature image
    *
    * @return void
    */
   public function makeSignature();
}