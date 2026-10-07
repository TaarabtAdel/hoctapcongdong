<?php

namespace App\Http\Middleware;

use App\Services\Settings\SettingsService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function __construct(private SettingsService $settings) {}

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->settings->get('maintenance_mode', false) && ! $request->is($this->settings->adminPath().'/*')) {
            if (! $request->user()?->hasRole('super_admin')) {
                return response()->view('front.maintenance', [], 503);
            }
        }

        return $next($request);
    }
}
