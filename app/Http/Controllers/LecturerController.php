<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TeamLeader;
use App\Models\TeamLeaderTimetable;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LecturerController extends Controller
{
    /**
     * Profile (like AdminController::show)
     */
    public function show()
    {
        $user = Auth::user();
        // follow your AdminController convention (relation named plural)
        $lecturer = $user->lecturers()->first();

        return view('lecturer.profile', compact('user', 'lecturer'));
    }

    /**
     * Update lecturer profile (users + lecturers), with optional password change
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $lecturer = $user->lecturers()->first(); // hasOne-like, using your plural style

        // Validate
        $request->validate([
            // users table
            'name'         => 'required|string|max:255',
            'nickname'     => 'nullable|string|max:255',
            'line_id'      => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',

            // lecturers table (adjust fields to your migration)
            'department'     => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',

            // password
            'current_password' => 'nullable|string|min:8',
            'password'         => 'nullable|string|min:8|confirmed',
        ]);

        // Update users
        $user->update([
            'name'         => $request->name,
            'nickname'     => $request->nickname,
            'line_id'      => $request->line_id,
            'phone_number' => $request->phone_number,
        ]);

        // Update lecturers
        $lecturer->update([
            'department'     => $request->department,
            'specialization' => $request->specialization,
        ]);

        // Optional password change
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('lecturer.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Dashboard: quick counts + recent users
     */
    public function dashboard(Request $request)
    {
        $roles = ['student', 'mentor', 'teamleader', 'lecturer', 'admin'];

        $counts = User::select('role', DB::raw('COUNT(*) AS total'))
            ->whereIn('role', $roles)
            ->groupBy('role')
            ->pluck('total', 'role');

        $recentUsers = User::latest()->take(8)->get();

        return view('lecturer.dashboard', compact('counts', 'recentUsers'));
    }

    /**
     * View Team Leaders Timetable (read-only), with filters (day/time_slot)
     */
    public function viewTeamLeadersTimetable(Request $request)
    {
        $day = $request->input('day');
        $time_slot = $request->input('time_slot');

        $query = TeamLeaderTimetable::query();

        if ($day)       $query->where('day', $day);
        if ($time_slot) $query->where('time_slot', $time_slot);

        $teamLeaderTimetables = $query->with('teamLeader.user')->get();

        return view('lecturer.team-leaders-timetables', compact('teamLeaderTimetables', 'request'));
    }

    /**
     * View Mentor-Students Timetable (read-only), with filters (day/time_slot/week_number)
     */
    public function viewMentorStudentsTimetable(Request $request)
    {
        $day         = $request->input('day');
        $time_slot   = $request->input('time_slot');
        $week_number = $request->input('week_number');

        $query = Timetable::query();

        if ($day)         $query->where('day', $day);
        if ($time_slot)   $query->where('time_slot', $time_slot);
        if ($week_number) $query->where('week_number', $week_number);

        // expect: Timetable has relations mentor.user and appointments.student.user
        $timetables = $query->with(['mentor.user', 'appointments.student.user'])->get();

        return view('lecturer.mentor-students-timetable', compact('timetables', 'request'));
    }

    /**
     * Read-only lists (Students / Mentors / Team Leaders)
     * For students/mentors we’ll query Users by role (keeps things simple).
     */
    public function viewStudents(Request $request)
    {
        $users = User::where('role', 'student')
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = trim($request->q);
                $q->where(function ($w) use ($term) {
                    $w->where('name', 'like', "%{$term}%")
                      ->orWhere('email', 'like', "%{$term}%");
                });
            })
            ->when($request->boolean('verified_only'), fn($q) => $q->whereNotNull('email_verified_at'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('lecturer.users.index', [
            'title' => 'Students',
            'role'  => 'student',
            'users' => $users,
            'request' => $request,
        ]);
    }

    public function viewMentors(Request $request)
    {
        $users = User::where('role', 'mentor')
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = trim($request->q);
                $q->where(function ($w) use ($term) {
                    $w->where('name', 'like', "%{$term}%")
                      ->orWhere('email', 'like', "%{$term}%");
                });
            })
            ->when($request->boolean('verified_only'), fn($q) => $q->whereNotNull('email_verified_at'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('lecturer.users.index', [
            'title' => 'Mentors',
            'role'  => 'mentor',
            'users' => $users,
            'request' => $request,
        ]);
    }

    public function viewTeamLeaders(Request $request)
    {
        $query = TeamLeader::with('user');

        if ($request->filled('team_leader_id')) {
            $query->where('team_leader_id', 'like', '%' . $request->team_leader_id . '%');
        }

        $teamLeaders = $query->paginate(10)->withQueryString();

        return view('lecturer.team_leaders.index', compact('teamLeaders', 'request'));
    }

    /**
     * Attendance placeholders (not implemented yet)
     */
    public function attendanceIndex(Request $request)
    {
        $users = User::whereIn('role', ['student','mentor','teamleader'])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('lecturer.attendance.index', compact('users'));
    }

    public function attendanceShow(User $user)
    {
        // TODO: Replace with real attendance model/records later
        $records = collect();

        return view('lecturer.attendance.show', compact('user', 'records'));
    }
}
