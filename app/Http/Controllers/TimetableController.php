<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
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
            return redirect()->route('mentor.timetables.edit', ['mentor_id' => $mentor_id])
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
        'day'          => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
        'time_slot'    => 'required|string|regex:/^\d{2}:\d{2}-\d{2}:\d{2}$/', // Format: HH:MM-HH:MM
        'table_number' => 'required|integer|min:1|max:25',
    ]);

    // Split the one-hour time slot into two 30-minute slots
    $timeSlots = $this->splitTimeSlot($request->time_slot);

    // Insert 32 rows (2 slots per week for 16 weeks)
    /* !Change Week Range in Here! */
    $timetables = [];
    foreach (range(4, 13) as $week_number) {
        foreach ($timeSlots as $timeSlot) {
            if ($timeSlot !== '9:00-10:00' && $timeSlot !== '10:00-11:00') {
                // Create a new timetable entry for each mentor
                $timetables[] = [
                    'mentor_id'    => $mentor->id,
                    'day'          => $request->day,
                    'time_slot'    => $timeSlot,
                    'table_number' => $request->table_number,
                    'week_number'  => (string) $week_number,
                    'reserved'     => false,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];
            } else {
                if ($request->table_number <= 4) {   // ✅ fixed here
                    $timetables[] = [
                        'mentor_id'    => $mentor->id,
                        'day'          => $request->day,
                        'time_slot'    => $timeSlot,
                        'table_number' => $request->table_number,
                        'week_number'  => (string) $week_number,
                        'reserved'     => false,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            }
        }
    }

    // Check for unique constraint violations
    $conflicts = Timetable::where('day', $request->day)
        ->whereIn('time_slot', $timeSlots)
        ->where('table_number', $request->table_number)
        ->exists();

    if ($conflicts) {
        return back()->withErrors([
            'conflict' => 'The selected time slot and table number is already reserved.',
        ]);
    }

    Timetable::insert($timetables);

    return redirect()->route('mentor.dashboard')
        ->with('success', 'Timetable reserved successfully.');
}
    public function edit(Request $request)
    {

        $mentor_id = Auth::user()->mentors->first()->id;

        // Check if there are any timetables for this mentor
        $existingTimetable = Timetable::where('mentor_id', $mentor_id)->exists();
        if (!$existingTimetable) {
            // Redirect to the create page if no timetables exist
            return redirect()->route('mentor.timetables.create')
                ->with('info', 'You haven\'t reserved yet. Please reserve your timetable first.');
        }

        // Proceed with edit logic if records exist
        $timetable = Timetable::where('mentor_id', $mentor_id)
            ->firstOrFail();

        return view('mentor.timetables.edit', compact('timetable'));
    }

    private function splitTimeSlot(string $timeSlot): array
    {
        [$start, $end] = explode('-', $timeSlot);

        // Convert to Carbon instances for easier manipulation
        $startTime = \Carbon\Carbon::createFromFormat('H:i', $start);
        $endTime = \Carbon\Carbon::createFromFormat('H:i', $end);

        // Generate two 30-minute slots
        $firstSlot = $startTime->format('H:i') . '-' . $startTime->copy()->addMinutes(30)->format('H:i');
        $secondSlot = $startTime->copy()->addMinutes(30)->format('H:i') . '-' . $endTime->format('H:i');

        return [$firstSlot, $secondSlot];
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

        // Split the one-hour time slot into two 30-minute slots
        $timeSlots = $this->splitTimeSlot($request->time_slot);

        // Check for conflicts with other mentors' reservations
        $conflicts = Timetable::where('mentor_id', '!=', $mentor_id)
            ->where('day', $request->day)
            ->where('table_number', $request->table_number)
            ->whereIn('time_slot', $timeSlots)
            ->exists();

        if ($conflicts) {
            return back()->withErrors(['conflict' => 'The selected time slot and table number is already reserved by another mentor.']);
        }

        // Fetch all the mentor's reserved timetables, ordered by week number
        $timetables = Timetable::where('mentor_id', $mentor_id)
            ->orderBy('week_number')
            ->get();

        // Check if the timetables exist
        if ($timetables->isEmpty()) {
            return back()->withErrors(['error' => 'No reservations found to update.']);
        }

        // Update the rows
        $updatedIndex = 0; // Tracks the position for the time slot to update
        foreach ($timetables as $timetable) {
            $timeSlotIndex = $updatedIndex % 2; // Alternates between 0 (first half) and 1 (second half)

            $timetable->update([
                'day' => $request->day,
                'time_slot' => $timeSlots[$timeSlotIndex],
                'table_number' => $request->table_number,
            ]);

            $updatedIndex++;
        }

        return redirect()->route('mentor.dashboard')->with('success', 'Reservation updated successfully.');
    }


    public function checkAvailability(Request $request)
    {
        // Define all possible combinations of days, one-hour time slots, and tables
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = [
            '09:00-10:00',
            '10:00-11:00',
            '11:00-12:00',
            '12:00-13:00',
            '13:00-14:00',
            '14:00-15:00',
            '15:00-16:00',
            '16:00-17:00'
            //,'17:00-18:00','18:00-19:00','19:00-20:00'
        ];

        // table count filters based on time slots -> for availability view
        $tables = range(1, 16);
        if (in_array($request->time_slot, ['16:00-17:00', '17:00-18:00', '18:00-19:00', '19:00-20:00'])) {
            $tables = range(1, 5);
        }
        if (in_array($request->time_slot, ['09:00-10:00', '10:00-11:00'])) {
            $tables = range(1, 2);
        }
        if (in_array($request->time_slot, ['11:00-12:00', '12:00-13:00', '13:00-14:00', '14:00-15:00'])) {
            $tables = range(1, 10);
        }

        // Fetch reserved timetables with mentor_id
        $reservedTimetables = Timetable::select('day', 'time_slot', 'table_number', 'mentor_id')
            ->distinct()
            ->get()
            ->toArray();

        // Create a list of all timetables with their reserved status and mentor_id
        $availableTimetables = [];
        foreach ($days as $day) {
            foreach ($timeSlots as $timeSlot) {
                foreach ($tables as $table) {
                    // Split the one-hour time slot into two 30-minute slots
                    [$firstSlot, $secondSlot] = $this->splitTimeSlot($timeSlot);

                    // Check if either 30-minute slot is reserved
                    $reservedTimetable = collect($reservedTimetables)->firstWhere(function ($timetable) use ($day, $firstSlot, $secondSlot, $table) {
                        return $timetable['day'] === $day &&
                            $timetable['table_number'] === $table &&
                            ($timetable['time_slot'] === $firstSlot || $timetable['time_slot'] === $secondSlot);
                    });

                    // Add timetable with reserved status and mentor_id
                    $availableTimetables[] = [
                        'day' => $day,
                        'time_slot' => $timeSlot,
                        'table_number' => $table,
                        'is_reserved' => $reservedTimetable ? 'Reserved' : 'Available',
                    ];
                }
            }
        }

        // Filter based on search inputs
        if ($request->filled('table_number')) {
            $availableTimetables = collect($availableTimetables)
                ->where('table_number', (int) $request->table_number)
                ->values()
                ->toArray();
        }
        if ($request->filled('time_slot')) {
            $availableTimetables = collect($availableTimetables)
                ->where('time_slot', $request->time_slot)
                ->values()
                ->toArray();
        }
        if ($request->filled('day')) {
            $availableTimetables = collect($availableTimetables)
                ->where('day', $request->day)
                ->values()
                ->toArray();
        }

        return view('mentor.timetables.availability', compact('availableTimetables', 'request'));
    }

    public function searchStudents(Request $request)
    {
        $students = collect(); // Default empty collection for students

        // Check if the form is submitted with input values
        if ($request->filled(['week_number', 'day', 'time_slot', 'table_number'])) {
            // Validate the input
            $request->validate([
                'week_number' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16',
                'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
                'time_slot' => 'required|string',
                'table_number' => 'required|integer|min:1|max:25',
            ]);

            // Fetch the timetable based on the provided search criteria
            $timetable = Timetable::where('week_number', $request->week_number)
                ->where('day', $request->day)
                ->where('time_slot', $request->time_slot)
                ->where('table_number', $request->table_number)
                ->first();

            // If a timetable is found, fetch the students registered for it
            if ($timetable) {
                $students = Appointment::where('timetable_id', $timetable->id)
                    ->with('student.user') // Load the student user data
                    ->get()
                    ->pluck('student') // Extract the student objects
                    ->unique('id');    // Ensure unique students
            }
        }

        return view('mentor.timetables.students', compact('students', 'request'));
    }
}
