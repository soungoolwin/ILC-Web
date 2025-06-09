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

        if (session('redirected')) {
            return abort(500, 'Redirect loop detected');
        }
        session(['redirected' => true]);

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

        $currentDate = Carbon::now();
        $checkerStartDate = Carbon::create(2024, 8, 1);
        
        if ($currentDate->lessThan($checkerStartDate)) {
            return redirect()->route('mentor.dashboard');
        }

        // Determine current semester
        $currentYear = 2024;
        $currentSemester = $currentDate->month <= 7 ? 1 : 2;
        
        // Create a semester identifier (e.g., "2024-1" or "2024-2")
        $currentSemesterKey = $currentYear . '-' . $currentSemester;
        
        // Check if mentor has been checked for this semester
        $lastCheckedSemester = $mentor->last_checked_semester ?? '';
        
        // Determine if we need to check
        $needsCheck = false;
        $semesterEndDate = $currentSemester == 1 
            ? Carbon::create($currentYear, 7, 31) 
            : Carbon::create($currentYear, 12, 31);
        
        // If we're past the semester end date and haven't checked for this semester
        if ($currentDate->greaterThan($semesterEndDate) && $lastCheckedSemester !== $currentSemesterKey) {
            $needsCheck = true;
        }

        if ($needsCheck) {
            if ($mentor->mentor_sem > 2) {
                $mentor->update([
                    'status' => 'suspended',
                    'last_checked_at' => now(),
                    'last_checked_semester' => $currentSemesterKey
                ]);
                return redirect()->route('mentor.suspended');
            } elseif ($mentor->mentor_sem <= 2 && $mentor->status !== 'suspended') {
                // Update will happen in the nextsem route after they complete the check
                return redirect()->route('mentor.nextsem', compact('mentor'));
            }
        }

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