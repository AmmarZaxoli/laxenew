<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    protected $routes = [
    'backups/*',
];
    public function handle($request, Closure $next, $guard = null)
    {
        // If not logged in, redirect to login
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            }
            return redirect()->route('login')
                ->with('error', 'You must log in first.');
        }

        return $next($request);
    }
}
