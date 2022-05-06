<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Numbers extends Facade {

    protected static function getFacadeAccessor() {
        return 'App\Services\Numbers';
    }

}