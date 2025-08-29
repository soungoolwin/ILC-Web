<?php

namespace App\Http\Controllers;

use App\Models\TeamLeader;
use App\Models\TeamLeaderTimetable;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $admin = $user->admins()->first();


        return view('admin.profile', compact('user', 'admin'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $admin = $user->admins()->first();

        // Validate the request
        $request->validate([
            // Fields from the `users` table
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'line_id' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',

            // Fields from the `admins` table
            'admin_id' => 'required|string|unique:admins,admin_id,' . $admin->id,

            // Password fields
            'current_password' => 'nullable|string|min:8',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update the `users` table
        $user->update([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'line_id' => $request->line_id,
            'phone_number' => $request->phone_number,
        ]);

        // Update the `admins` table
        $admin->update([
            'admin_id' => $request->admin_id,
        ]);

        // Update password if provided and valid
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }
    //for check timetable of team leader
    public function viewTeamLeadersTimetable(Request $request)
    {
        // Fetch the search parameters
        $day = $request->input('day');
        $time_slot = $request->input('time_slot');

        // Query the team leaders timetable based on search parameters
        $query = TeamLeaderTimetable::query();

        if ($day) {
            $query->where('day', $day);
        }

        if ($time_slot) {
            $query->where('time_slot', $time_slot);
        }

        $teamLeaderTimetables = $query->with('teamLeader.user')->get();

        return view('admin.team-leaders-timetables', compact('teamLeaderTimetables', 'request'));
    }

    //for check timetable of mentor-student timetable
    public function viewMentorStudentsTimetable(Request $request)
    {
        // Fetch search criteria
        $day = $request->input('day');
        $time_slot = $request->input('time_slot');
        $week_number = $request->input('week_number');

        // Base query
        $query = Timetable::query();

        if ($day) {
            $query->where('day', $day);
        }

        if ($time_slot) {
            $query->where('time_slot', $time_slot);
        }

        if ($week_number) {
            $query->where('week_number', $week_number);
        }

        // Fetch timetables with mentors and students
        $timetables = $query->with(['mentor.user', 'appointments.student.user'])->get();

        return view('admin.mentor-students-timetable', compact('timetables', 'request'));
    }


    // View all team leaders
    public function viewTeamLeaders(Request $request)
    {
        $query = TeamLeader::with('user');

        // Check if a search term is provided
        if ($request->filled('team_leader_id')) {
            $query->where('team_leader_id', 'like', '%' . $request->team_leader_id . '%');
        }

        // Paginate the results
        $teamLeaders = $query->paginate(10);

        return view('admin.team_leaders.index', compact('teamLeaders', 'request'));
    }

    // Delete a team leader
    public function deleteTeamLeader($id)
    {
        $teamLeader = TeamLeader::findOrFail($id); // Find team leader by ID

        // Delete the associated user and team leader record
        $teamLeader->user()->delete();
        $teamLeader->delete();

        return redirect()->route('dashboard.team_leaders')->with('success', 'Team Leader deleted successfully!');
    }

    // View all users
    public function viewUsers(Request $request)
    {
        $query = \App\Models\User::query();

        // Search by email if provided
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Exclude admins (also handles null role safely)
    $query->where(function ($qq) {
        $qq->whereNull('role')->orWhere('role', '!=', 'admin');
    });

    // OPTIONAL: only verified if requested (?only_verified=1)
    if ($request->boolean('only_verified')) {
        $query->whereNotNull('email_verified_at');
    }

        // Paginate results
        $users = $query->paginate(50);

        return view('admin.team_leaders.users', compact('users', 'request'));
    }

    // Delete a user
    public function deleteUser($id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Delete the user
        $user->delete();

        return redirect()->route('dashboard.users')->with('success', 'User deleted successfully!');
    }
}
