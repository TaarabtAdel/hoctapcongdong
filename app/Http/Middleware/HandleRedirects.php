<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET')) {
            $path = '/'.trim($request->path(), '/');
            if ($path !== '/') {
                $redirect = Redirect::query()->where('from_path', $path)->first();
                if ($redirect) {
                    $redirect->increment('hits');

                    return redirect($redirect->to_path, $redirect->status_code);
                }
            }
        }

        return $next($request);
    }
}
