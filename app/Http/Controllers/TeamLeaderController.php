<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeamLeaderController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $teamLeader = $user->teamLeaders()->first();

        return view('team_leader.profile', compact('user', 'teamLeader'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $teamLeader = $user->teamLeaders()->first();

        // Validate the request
        $request->validate([
            // Fields from the `users` table
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'line_id' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',

            // Fields from the `team_leaders` table
            'team_leader_id' => 'required|string|unique:team_leaders,team_leader_id,' . $teamLeader->id,

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

        // Update the `team_leaders` table
        $teamLeader->update([
            'team_leader_id' => $request->team_leader_id,
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

        return redirect()->route('team_leader.profile')->with('success', 'Profile updated successfully.');
    }
    public function viewTimetables(Request $request)
    {

        // Initialize timetables as empty
        $timetables = collect();

        // Only fetch timetables if search criteria are provided
        if ($request->filled('week_number') || $request->filled('day') || $request->filled('time_slot') || $request->filled('table_number')) {
            $timetables = Timetable::with(['mentor.user', 'appointments.student.user'])
                ->when($request->filled('week_number'), function ($query) use ($request) {
                    $query->where('week_number', $request->week_number);
                })
                ->when($request->filled('day'), function ($query) use ($request) {
                    $query->where('day', $request->day);
                })
                ->when($request->filled('time_slot'), function ($query) use ($request) {
                    $query->where('time_slot', $request->time_slot);
                })
                ->when($request->filled('table_number'), function ($query) use ($request) {
                    $query->where('table_number', $request->table_number);
                })
                ->get()
                ->groupBy('mentor.user.name');
        }

        return view('team_leader.view_timetables', compact('timetables', 'request'));
    }
}
