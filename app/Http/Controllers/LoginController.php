<?php

namespace App\Http\Controllers;

use App\Scopes\CurrentSemesterScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Row for the current semester (via CurrentSemesterScope). If it
        // exists, this mentor is already set up for this term.
        $mentor = $user->mentors()->first();

        if ($mentor) {
            if ($mentor->status === 'paused') {
                return redirect()->route('mentor.pause');
            }

            if ($mentor->status === 'suspended') {
                return redirect()->route('mentor.suspended');
            }

            return redirect()->route('mentor.dashboard');
        }

        // No row for the current semester: figure out whether this is a
        // brand-new mentor (never registered) or a returning one who
        // hasn't confirmed for the new semester yet.
        $lastMentor = $user->mentors()
            ->withoutGlobalScope(CurrentSemesterScope::class)
            ->latest('id')
            ->first();

        if (! $lastMentor) {
            return redirect()->route('mentor.profile')->withErrors(['error' => 'Mentor profile not found.']);
        }

        if ($lastMentor->status === 'paused') {
            return redirect()->route('mentor.pause');
        }

        if ($lastMentor->status === 'suspended') {
            return redirect()->route('mentor.suspended');
        }

        // How many semesters has this mentor already completed? Once
        // they've done more than 2, they're suspended instead of being
        // offered another term.
        $semestersCompleted = $user->mentors()
            ->withoutGlobalScope(CurrentSemesterScope::class)
            ->count();

        if ($semestersCompleted > 2) {
            $lastMentor->update(['status' => 'suspended']);

            return redirect()->route('mentor.suspended');
        }

        return redirect()->route('mentor.nextsem', ['mentor' => $lastMentor]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
