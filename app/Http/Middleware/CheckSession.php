<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckSession
{
    public function handle(Request $request, Closure $next)
    {
          $response = $next($request);
        
        // Add no-cache headers
        return $response->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
        // Skip authentication check for these routes
        if ($request->is('/') || $request->is('logout')) {
            return $next($request);
        }

        if (!Auth::guard('account')->check()) {
            Log::debug('Auth check failed', [
                'session' => session()->all(),
                'user' => Auth::guard('account')->user(),
                'cookie' => $request->cookie()
                
            ]
        );
        }
        
        return $next($request);
    }
}
