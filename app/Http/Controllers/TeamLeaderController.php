<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use Illuminate\Http\Request;

class TeamLeaderController extends Controller
{
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
