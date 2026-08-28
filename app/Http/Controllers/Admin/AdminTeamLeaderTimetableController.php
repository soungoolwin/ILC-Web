<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\TeamLeader;
use App\Models\TeamLeaderTimetable;
use Illuminate\Http\Request;

class AdminTeamLeaderTimetableController extends Controller
{
    public function edit($team_leader_id)
    {
        $teamLeader = TeamLeader::with('user')->findOrFail($team_leader_id);

        $timetable = TeamLeaderTimetable::where('team_leader_id', $teamLeader->id)->firstOrFail();

        $timeSlots = Semester::TEAM_LEADER_TIME_SLOTS;
        $days = Semester::DAYS;

        return view('admin.timetables.team-leader-edit', compact('timetable', 'teamLeader', 'timeSlots', 'days'));
    }

    public function update(Request $request, $team_leader_id)
    {
        $teamLeader = TeamLeader::findOrFail($team_leader_id);

        $timetable = TeamLeaderTimetable::where('team_leader_id', $teamLeader->id)->firstOrFail();

        $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'time_slot' => 'required|in:'.implode(',', Semester::TEAM_LEADER_TIME_SLOTS),
        ]);

        $slotLimits = $teamLeader->semester->teamLeaderSlotLimits();

        // Enforce slot capacity, excluding this team leader's own reservation
        $count = TeamLeaderTimetable::where('day', $request->day)
            ->where('time_slot', $request->time_slot)
            ->where('id', '!=', $timetable->id)
            ->count();

        if ($count >= ($slotLimits[$request->time_slot] ?? 0)) {
            return back()->withErrors(['error' => 'All slots are full for the selected time and day.']);
        }

        $timetable->update([
            'day' => $request->day,
            'time_slot' => $request->time_slot,
        ]);

        return redirect()->route('admin.team_leaders_timetable')
            ->with('success', 'Team leader reservation updated successfully.');
    }
}
