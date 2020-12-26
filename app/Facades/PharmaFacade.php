<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PharmaFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'Pharma';
    }

}
