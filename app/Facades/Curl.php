<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Curl extends Facade{
    protected static function getFacadeAccessor(){ return 'curl'; }
}