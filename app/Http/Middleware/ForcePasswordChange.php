<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user && $user->must_change_password && ! $request->routeIs('admin.profile.*', 'admin.logout')) {
            return redirect()->route('admin.profile.edit')->with('warning', __('admin.profile.must_change_password'));
        }

        return $next($request);
    }
}
