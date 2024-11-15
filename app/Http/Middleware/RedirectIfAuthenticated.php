<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Redirect based on the user's role
            if ($user->role === 'student') {
                return redirect('/student/dashboard');
            } elseif ($user->role === 'mentor') {
                return redirect('/mentor/dashboard');
            } elseif ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }
        }

        return $next($request);
    }
}
