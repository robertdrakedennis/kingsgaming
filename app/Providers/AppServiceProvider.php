<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;                                       // <-- add this
use kanalumaddela\LaravelSteamLogin\SteamLogin;                            // <-- add this
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(SteamLogin $steam)
    {
        Schema::defaultStringLength(191);
        View::share('steam_login', $steam->loginUrl());
        View::share('steam_button_small', SteamLogin::button('small'));
        View::share('steam_button_large', SteamLogin::button('large'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
