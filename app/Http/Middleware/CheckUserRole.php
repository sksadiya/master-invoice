<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Ensure the user is authenticated and then check the role
         // If the user is not authenticated, allow them to proceed
         if (!$user) {
            return $next($request);
        }

        // Check if the user role is '0' (or any other restricted role)
        if ($user->role === 0) {
            if ($request->is('login')) {
                return $next($request);
            }
            return redirect('/login')->with('error', 'You do not have access to this application.');
        }
        return $next($request);
    }
}
