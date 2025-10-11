<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $types = ['admin']; // Define allowed user types
        if (empty(Auth::user()) || !in_array(@Auth::user()->type, $types)) {
            abort(403, 'Unauthorized action.'); // Or redirect to an error page
        }
        return $next($request);
    }
}
