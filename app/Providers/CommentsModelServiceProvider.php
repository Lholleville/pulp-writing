<?php

namespace App\Providers;

use App\Comment;
use App\Observers\CommentsObserver;
use Illuminate\Support\ServiceProvider;

class CommentsModelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Comment::observe(CommentsObserver::class);
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
