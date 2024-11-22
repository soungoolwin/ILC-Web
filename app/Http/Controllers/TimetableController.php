<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{
    public function create()
    {
        $mentor_id = Auth::user()->mentors->first()->id;

        // Check if there are existing timetables for this mentor
        $existingTimetable = Timetable::where('mentor_id', $mentor_id)->exists();

        if ($existingTimetable) {
            // Redirect to the edit page if timetables exist
            return redirect()->route('timetables.edit', ['mentor_id' => $mentor_id])
                ->with('info', 'You already have a reserved timetable. You can edit it.');
        }

        // Otherwise, show the reservation creation page
        return view('mentor.timetables.create');
    }

    /**
     * Store the new timetable reservation.
     */
    public function store(Request $request)
    {
        $mentor = Auth::user()->mentors()->first();

        // Validate input
        $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'time_slot' => 'required|string|max:20', // Add more time format validation if needed
            'table_number' => 'required|integer|min:1',
        ]);

        // Insert 16 rows for 16 weeks
        $timetables = [];
        foreach (range(1, 16) as $week_number) {
            $timetables[] = [
                'mentor_id' => $mentor->id,
                'day' => $request->day,
                'time_slot' => $request->time_slot,
                'table_number' => $request->table_number,
                'week_number' => (string)$week_number,
                'reserved' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Check for unique constraint violations (optional to prevent errors in runtime)
        $conflicts = Timetable::where('day', $request->day)
            ->where('time_slot', $request->time_slot)
            ->where('table_number', $request->table_number)
            ->exists();

        if ($conflicts) {
            return back()->withErrors(['conflict' => 'The selected time slot and table number is already reserved.']);
        }

        Timetable::insert($timetables);

        return redirect()->route('mentor.dashboard')->with('success', 'Timetable reserved successfully.');
    }

    public function edit(Request $request)
    {
        $mentor_id = Auth::user()->mentors->first()->id;

        // Get the first timetable row for the mentor's reserved slot
        $timetable = Timetable::where('mentor_id', $mentor_id)
            ->where('reserved', true)
            ->firstOrFail();

        return view('mentor.timetables.edit', compact('timetable'));
    }

    public function update(Request $request)
    {
        $mentor_id = Auth::user()->mentors->first()->id;

        // Validate the request
        $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'time_slot' => 'required|in:09:00-10:00,10:00-11:00,11:00-12:00,12:00-13:00,13:00-14:00,14:00-15:00,15:00-16:00,16:00-17:00,17:00-18:00,18:00-19:00,19:00-20:00',
            'table_number' => 'required|integer|between:1,25',
        ]);

        // Fetch all the mentor's reserved timetables
        $timetables = Timetable::where('mentor_id', $mentor_id)
            ->where('reserved', true)
            ->get();

        // Update existing rows
        foreach ($timetables as $timetable) {
            $timetable->update([
                'day' => $request->day,
                'time_slot' => $request->time_slot,
                'table_number' => $request->table_number,
            ]);
        }

        return redirect()->route('mentor.dashboard')->with('success', 'Reservation updated successfully.');
    }
}
