<?php

namespace App\Http\Controllers\TeamLeader;
use App\Http\Controllers\Controller;

use App\Models\Semester;
use App\Models\TeamLeaderTimetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamLeaderTimetableController extends Controller
{
    public function create()
    {
        $timeSlots = Semester::TEAM_LEADER_TIME_SLOTS;
        $days = Semester::DAYS;
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
            'time_slot' => 'required|in:' . implode(',', Semester::TEAM_LEADER_TIME_SLOTS),
        ]);



        // Count the number of reservations for the selected time slot and day
        $count = TeamLeaderTimetable::where('time_slot', $request->time_slot)
            ->where('day', $request->day)
            ->count();

        $slotLimits = Semester::current()->teamLeaderSlotLimits();

        if ($count >= $slotLimits[$request->time_slot]) {
            return back()->withErrors(['error' => 'All slots are full for the selected time and day.']);
        }



        // Create the reservation
        $new = TeamLeaderTimetable::create([
            'team_leader_id' => $teamLeader->id,
            'semester_id' => $teamLeader->semester_id,
            'time_slot' => $request->time_slot,
            'day' => $request->day,
        ]);

        return redirect()->route('team_leader.dashboard')->with('success', 'Timetable reserved successfully!');
    }

    public function checkAvailability(Request $request)
    {
        $timeSlots = Semester::TEAM_LEADER_TIME_SLOTS;
        $days = Semester::DAYS;

        $slotLimits = Semester::current()->teamLeaderSlotLimits();

        // Filtered Search Result
        $availability = null;
        $day = $request->input('day');
        $time_slot = $request->input('time_slot');

        if ($day && $time_slot && isset($slotLimits[$time_slot])) {
            $reservedCount = TeamLeaderTimetable::where('day', $day)
                ->where('time_slot', $time_slot)
                ->count();

            $availability = [
                'day' => $day,
                'time_slot' => $time_slot,
                'reserved' => $reservedCount,
                'available' => $slotLimits[$time_slot] - $reservedCount,
                'limit' => $slotLimits[$time_slot],
            ];
        }

        // All grouped data: [day][time_slot]
        $allTimetables = [];
        foreach ($days as $d) {
            foreach ($timeSlots as $slot) {
                $reserved = TeamLeaderTimetable::where('day', $d)
                    ->where('time_slot', $slot)
                    ->count();

                $limit = $slotLimits[$slot] ?? 0;
                $available = max(0, $limit - $reserved);

                $allTimetables[$d][$slot] = [
                    'reserved' => $reserved,
                    'available' => $available,
                    'limit' => $limit,
                ];
            }
        }

        return view('team_leader.timetables.availability', compact(
            'timeSlots',
            'days',
            'slotLimits',
            'availability',
            'allTimetables',
            'request'
        ));
    }
}