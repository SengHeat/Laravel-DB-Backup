<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
//    ->withSchedule(function (Schedule $schedule) {
//        Schedule::command('backup:clean')->daily()->at('01:00');  // Clean old backups
//        Schedule::command('backup:run')->daily()->at('02:00');    // Run new backup
//        Schedule::command('backup:monitor')->daily()->at('03:00'); // Health check
//    })
    ->create();
