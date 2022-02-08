<?php
namespace AndrykVP\Rancor\Audit\Enums;

enum Access: string
{
   case LOGIN = 'login';
   case REGISTRATION = 'registration';

   /**
    * Method to create a message to render the Log in views
    */
   public function message(): string
   {
      return match($this)
      {
         Access::LOGIN => 'has logged in',
         Access::REGISTRATION => 'has registered a new account',
      };
   }
}