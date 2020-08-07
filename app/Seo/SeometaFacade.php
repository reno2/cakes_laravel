<?php
namespace App\Seo;

use Illuminate\Support\Facades\Facade;

class SeometaFacade extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'seometa';
    }
}
