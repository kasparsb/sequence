<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ApiKeys extends Facade {

    protected static function getFacadeAccessor() {
        return 'App\Services\ApiKeys';
    }

}