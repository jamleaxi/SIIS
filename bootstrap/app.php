<?php

use App\Http\Middleware\CheckUnavailability;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register as named middleware
        $middleware->alias([
            'check.unavailable'=>CheckUnavailability::class,
        ]);

        // System wide lockdown
        $middleware->web('check.unavailable');
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('backup:db')->everyFourHours();
        // $schedule->command('backup:db')->dailyAt('06:00')->withoutOverlapping(); // every 6:00AM
        // $schedule->command('backup:db')->dailyAt('18:00')->withoutOverlapping(); // every 6:00PM
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
