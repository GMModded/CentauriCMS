<?php

namespace App\Providers;

use Centauri\Extension\Cookie\Handler\CookieSessionHandler;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Session::extend("cookie", function($app) {
            return new CookieSessionHandler;
        });
    }
}
