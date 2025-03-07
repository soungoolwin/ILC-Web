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

        // Check if the team leader already has a reservation
        $existingReservation = TeamLeaderTimetable::where('team_leader_id', $teamLeader->id)->first();

        if ($existingReservation) {
            return redirect()->route('team_leader.dashboard')->withErrors(['error' => 'You have already reserved a time slot.']);
        }

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
            '11:00-13:00' => 7,
            '13:00-15:00' => 7,
            '15:00-17:00' => 7,
            '17:00-20:00' => 5,
        ];

        if ($count >= $slotLimits[$request->time_slot]) {
            return back()->withErrors(['error' => 'All slots are full for the selected time and day.']);
        }



        // Create the reservation
        $new = TeamLeaderTimetable::create([
            'team_leader_id' => $teamLeader->id,
            'time_slot' => $request->time_slot,
            'day' => $request->day,
        ]);

        return redirect()->route('team_leader.dashboard')->with('success', 'Timetable reserved successfully!');
    }

    public function checkAvailability(Request $request)
    {
        $timeSlots = ['09:00-11:00', '11:00-13:00', '13:00-15:00', '15:00-17:00', '17:00-20:00'];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // Initialize the results
        $availability = [];

        // Filter criteria
        $day = $request->input('day');
        $time_slot = $request->input('time_slot');

        if ($day && $time_slot) {
            // Get the count of reservations for the selected time slot and day
            $reservedCount = TeamLeaderTimetable::where('day', $day)
                ->where('time_slot', $time_slot)
                ->count();

            // Define the slot limits
            $slotLimits = [
                '09:00-11:00' => 5,
                '11:00-13:00' => 7,
                '13:00-15:00' => 7,
                '15:00-17:00' => 7,
                '17:00-20:00' => 5,
            ];

            $availability = [
                'day' => $day,
                'time_slot' => $time_slot,
                'reserved' => $reservedCount,
                'available' => $slotLimits[$time_slot] - $reservedCount,
                'limit' => $slotLimits[$time_slot],
            ];
        }

        return view('team_leader.timetables.availability', compact('timeSlots', 'days', 'availability', 'request'));
    }
}
