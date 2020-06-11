<?php

namespace AndrykVP\SWC\Http\Controllers;

use Illuminate\Http\Request;
use AndrykVP\SWC\Facades\IDGenFacade as IDGen;
use App\User;

class IDGenController
{
   public function signature()
   {
      $user = User::find(1);

      //print_r($user);
      IDGen::makeSignature($user);
   }
}