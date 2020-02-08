<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Sunat extends Facade{
    protected static function getFacadeAccessor()
    {
        return'sunat';
    }
}