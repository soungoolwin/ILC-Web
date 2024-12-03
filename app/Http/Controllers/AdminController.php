<?php

namespace App\Http\Controllers;

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
}
