<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('account')->check()) {
            return redirect()->route('login');
        }

        if (Auth::guard('account')->user()->role !== 'admin') {
            abort(403, 'ببورە تو نەشێ ببینی');
            
        }

        return $next($request);
    }
}
