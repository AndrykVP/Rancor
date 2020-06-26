<?php

namespace AndrykVP\SWC\IDGen\Facades;

use Illuminate\Support\Facades\Facade;

class IDGenFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'idgen';
    }
}