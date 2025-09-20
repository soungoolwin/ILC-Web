<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return response()
            ->view('auth.login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    /**
     * Handle login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        /*
        It was causing 500 errors after each wrong login.

        if (session('redirected')) {
            return abort(500, 'Redirect loop detected');
        }
        session(['redirected' => true]);
        */

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect based on role
            if ($user->role === 'mentor') {
                return $this->handleMentorLogin($user);
            } elseif ($user->role === 'student') {
                return redirect()->route('student.dashboard');
            } elseif ($user->role === 'team_leader') {
                return redirect()->route('team_leader.dashboard');
            } else {
                return redirect()->route('admin.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    /**
     * Handle mentor-specific login logic.
     */
    private function handleMentorLogin($user)
    {
        $mentor = $user->mentors()->first();

        if (!$mentor) {
            return redirect()->route('mentor.profile')->withErrors(['error' => 'Mentor profile not found.']);
        }
        
        if ($mentor->status === 'paused') {
            return redirect()->route('mentor.pause');
        }

        // Get the current date
        $currentDate = Carbon::now();

        // Only trigger the checker after July 31st, 2025
        $checkerStartDate = Carbon::create(2024, 8, 1);
        if ($currentDate->lessThan($checkerStartDate)) {
            // Redirect to the mentor dashboard if before the checker start date
            return redirect()->route('mentor.dashboard');
        }

        // Semester end dates
        $semesterEndDates = [
            Carbon::create($currentDate->year, 12, 31),
            Carbon::create($currentDate->year, 7, 31),
        ];

        // Determine the last semester end date
        $lastSemesterEndDate = $currentDate->greaterThan($semesterEndDates[1]) ? $semesterEndDates[1] : $semesterEndDates[0];

        // Check if the mentor has already been checked after the last semester end date
        if ($mentor->last_checked_at) {
            $lastCheckedAt = Carbon::parse($mentor->last_checked_at);

            if ($lastCheckedAt->lessThanOrEqualTo($lastSemesterEndDate)) {
                if ($mentor->mentor_sem > 2) {
                    $mentor->update(['status' => 'suspended']);
                    return redirect()->route('mentor.suspended');
                } elseif ($mentor->mentor_sem <=  2 && $mentor->status !== 'suspended') {
                    return redirect()->route('mentor.nextsem', compact('mentor'));
                }
            }
        }

        // Default redirect for mentors
        return redirect()->route('mentor.dashboard');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}