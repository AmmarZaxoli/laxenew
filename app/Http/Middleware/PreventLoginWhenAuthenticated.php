<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventLoginWhenAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('account')->check()) {
            return redirect()->route('dashboard');
        }

        // Add cache control headers
        $response = $next($request);
        return $response->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }
}
