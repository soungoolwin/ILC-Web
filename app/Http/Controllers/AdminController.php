<?php

namespace App\Http\Controllers;

use App\Models\TeamLeader;
use App\Models\TeamLeaderTimetable;
use App\Models\Timetable;
use App\Models\User;
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
        $team_leader_id = $request->input('team_leader_id');

        // Query the team leaders timetable based on search parameters
        $query = TeamLeaderTimetable::query();

        if ($day) {
            $query->where('day', $day);
        }

        if ($time_slot) {
            $query->where('time_slot', $time_slot);
        }

        if ($team_leader_id) {
            $query->whereHas('teamLeader', function ($q) use ($team_leader_id) {
                $q->where('team_leader_id', 'like', '%' . $team_leader_id . '%');
            });
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


    // View all users
    public function viewUsers(Request $request)
    {
        $query = User::query();

        // Check if a search term is provided
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }



        // Paginate the results
        $users = $query->paginate(50);

        return view('admin.users.index', compact('users', 'request'));
    }

    // Delete a user
    public function deleteUser($id)
    {
        $authUser = Auth::user();

        // Ensure the deleter is an admin
        if (!$authUser || $authUser->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Find user by ID
        $user = User::findOrFail($id);

        // Prevent deleting admin users
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Cannot delete admin users.');
        }

        if ($user->id === $authUser->id) {
            return redirect()->route('admin.users.index')->with('error', 'You might just create a timeloop. do not delete your own account.');
        }

        // Delete the user
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "'{$user->name}' was deleted successfully! Email - {$user->email}");
    }
}
