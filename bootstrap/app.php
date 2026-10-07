<?php

use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Middleware\EnsureUserCanAccessAdmin;
use App\Http\Middleware\ForcePasswordChange;
use App\Http\Middleware\HandleRedirects;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (): void {
            require base_path('routes/admin.php');
            require base_path('routes/pages.php');
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function (Request $request): string {
            $adminPath = trim(config('htcd.admin_path', 'admin'), '/');

            if ($request->is($adminPath) || $request->is($adminPath.'/*')) {
                return route('admin.login');
            }

            return route('admin.login');
        });

        $middleware->alias([
            'admin.access' => EnsureUserCanAccessAdmin::class,
            'admin.password' => ForcePasswordChange::class,
            'maintenance' => CheckMaintenanceMode::class,
        ]);
        $middleware->web(append: [
            HandleRedirects::class,
            CheckMaintenanceMode::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withSchedule(function (Schedule $schedule): void {
        $schedule->command('content:publish-scheduled')->everyMinute();
        $schedule->command('trash:purge')->daily();
    })->create();
