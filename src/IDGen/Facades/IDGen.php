<?php

namespace AndrykVP\SWC\Facades;

use Illuminate\Support\Facades\Facade;

class IDGen extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'idgen';
    }
}