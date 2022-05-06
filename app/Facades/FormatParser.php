<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class FormatParser extends Facade {

    protected static function getFacadeAccessor() {
        return 'App\Services\FormatParser';
    }

}