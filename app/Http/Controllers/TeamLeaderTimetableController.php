<?php

namespace App\Http\Controllers;

use App\Models\TeamLeaderTimetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamLeaderTimetableController extends Controller
{
    public function create()
    {
        $timeSlots = ['09:00-11:00', '11:00-13:00', '13:00-15:00', '15:00-17:00', '17:00-20:00'];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        return view('team_leader.timetables.create', compact('timeSlots', 'days'));
    }

    public function store(Request $request)
    {
        $teamLeader = Auth::user()->teamLeaders->first();

        // Validate the request
        $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'time_slot' => 'required|in:09:00-11:00,11:00-13:00,13:00-15:00,15:00-17:00,17:00-20:00',
        ]);

        // Count the number of reservations for the selected time slot and day
        $count = TeamLeaderTimetable::where('time_slot', $request->time_slot)
            ->where('day', $request->day)
            ->count();

        // Enforce slot limits
        $slotLimits = [
            '09:00-11:00' => 5,
            '11:00-13:00' => 10,
            '13:00-15:00' => 10,
            '15:00-17:00' => 10,
            '17:00-20:00' => 5,
        ];

        if ($count >= $slotLimits[$request->time_slot]) {
            return back()->withErrors(['error' => 'All slots are full for the selected time and day.']);
        }

        // Create the reservation
        TeamLeaderTimetable::create([
            'team_leader_id' => $teamLeader->id,
            'time_slot' => $request->time_slot,
            'day' => $request->day,
        ]);

        return redirect()->route('team_leader.dashboard')->with('success', 'Timetable reserved successfully!');
    }
}
