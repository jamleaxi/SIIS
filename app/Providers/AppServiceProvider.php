<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Listeners\LogLogin;
use App\Listeners\LogLogout;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        date_default_timezone_set(config('app.timezone')); // Set the default timezone to Manila

        if (app()->environment('production'))
        {
            URL::forceScheme('https');
        }

        Event::listen(Login::class, LogLogin::class);
        Event::listen(Logout::class, LogLogout::class);
    }
}
