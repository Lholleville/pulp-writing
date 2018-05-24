<?php

namespace App\Providers;

use App\Listelecture;
use App\Observers\ListelectureObserver;
use Illuminate\Support\ServiceProvider;

class ListelectureModelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Listelecture::observe(ListelectureObserver::class);
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
