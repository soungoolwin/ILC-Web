<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

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

        // Get the current date
        $currentDate = Carbon::now();

        // Only trigger the checker after July 31st, 2025
        $checkerStartDate = Carbon::create(2025, 8, 1);
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
        if (!$mentor->last_checked_at || $mentor->last_checked_at->lessThanOrEqualTo($lastSemesterEndDate)) {
            // Redirect to the appropriate page based on mentor_sem
            if ($mentor->mentor_sem >= 2) {
                $mentor->update(['status' => 'suspended']);
                return view('mentor.suspended');
            } elseif ($mentor->mentor_sem < 2) {
                return view('mentor.nextsem', compact('mentor'));
            }
        }

        // Default redirect for mentors
        return redirect()->route('mentor.dashboard');
    }

    /**
     * Handle mentor confirmation for the next semester.
     */

     public function confirmNextSemester(Request $request)
{
    $user = Auth::user();
    $mentor = $user->mentors()->first();

    if (!$mentor) {
        return redirect()->route('mentor.profile')->withErrors(['error' => 'Mentor profile not found.']);
    }

    // Check the user's response
    if ($request->input('confirm') === 'yes') {
        // Increment mentor_sem, set status to active, and redirect to dashboard
        $mentor->increment('mentor_sem');
        $mentor->update([
            'status' => 'active',
            'last_checked_at' => Carbon::now(),
        ]);

        return redirect()->route('mentor.dashboard')->with('success', 'You have confirmed to be a mentor for the next semester.');
    } else {
        // Set status to paused and redirect to the paused page
        $mentor->update([
            'status' => 'paused',
            'last_checked_at' => Carbon::now(),
        ]);

        return view('mentor.pause');
    }
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}