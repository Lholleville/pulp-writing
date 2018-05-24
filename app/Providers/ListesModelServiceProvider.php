<?php

namespace App\Providers;

use App\Liste;
use App\Observers\ListesObserver;
use Illuminate\Support\ServiceProvider;

class ListesModelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Liste::observe(ListesObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
