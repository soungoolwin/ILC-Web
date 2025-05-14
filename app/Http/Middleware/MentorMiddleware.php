<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MentorMiddleware
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

            // Ensure the user is a mentor
            if ($user->role !== 'mentor') {
                return redirect('/' . $user->role . '/dashboard');
            }

            // Check mentor-specific status
            $mentor = $user->mentors()->first();

            if ($mentor) {
                // Redirect paused mentors to the pause page
                if ($mentor->status === 'paused') {
                    return redirect()->route('mentor.pause');
                }

                // Redirect suspended mentors to the suspended page
                if ($mentor->status === 'suspended') {
                    return redirect()->route('mentor.suspended');
                }
            }
        }

        return $next($request);
    }
}