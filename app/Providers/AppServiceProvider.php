<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('\App\Services\ApiKeys', function($app){
            return new \App\Services\ApiKeys();
        });
        $this->app->singleton('\App\Services\FormatParser', function($app){
            return new \App\Services\FormatParser();
        });
        $this->app->singleton('\App\Services\Numbers', function($app){
            return new \App\Services\Numbers();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
