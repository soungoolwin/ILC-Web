<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Semester;
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
            // Mentors can view but not edit — send them to the read-only show page.
            return redirect()->route('mentor.timetables.show')
                ->with('info', 'You already have a reserved timetable. Please contact an admin to make any changes.');
        }

        // Otherwise, show the reservation creation page
        $capacityMatrix = Semester::current()->hourSlotMatrix();

        return view('mentor.timetables.create', compact('capacityMatrix'));
    }

    public function show()
    {
        $mentor_id = Auth::user()->mentors->first()->id;

        $timetable = Timetable::where('mentor_id', $mentor_id)->first();

        if (! $timetable) {
            return redirect()->route('mentor.timetables.create')
                ->with('info', 'You haven\'t reserved a timetable yet.');
        }

        return view('mentor.timetables.show', compact('timetable'));
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
            'time_slot' => 'required|string|regex:/^\d{2}:\d{2}-\d{2}:\d{2}$/', // Format: HH:MM-HH:MM
            'table_number' => 'required|integer|min:1|max:30',
        ]);

        // Split the one-hour time slot into two 30-minute slots
        $timeSlots = $this->splitTimeSlot($request->time_slot);

        // Enforce this semester's configured table capacity for the slot.
        $capacity = Semester::current()->tableCapacityForHourSlot($request->day, $request->time_slot);
        if ($request->table_number > $capacity) {
            return back()->withErrors([
                'conflict' => "Only {$capacity} tables are available for {$request->day} {$request->time_slot}.",
            ]);
        }

        // Insert 32 rows (2 slots per week for 16 weeks)
        /* !Change Week Range in Here! */
        $timetables = [];
        foreach (range(4, 13) as $week_number) {
            foreach ($timeSlots as $timeSlot) {
                $timetables[] = [
                    'mentor_id' => $mentor->id,
                    'semester_id' => $mentor->semester_id,
                    'day' => $request->day,
                    'time_slot' => $timeSlot,
                    'table_number' => $request->table_number,
                    'week_number' => (string) $week_number,
                    'reserved' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Only another mentor shift is a conflict. Student-created table slots
        // have no mentor yet and can be claimed by this shift.
        $conflicts = Timetable::where('day', $request->day)
            ->whereIn('time_slot', $timeSlots)
            ->where('table_number', $request->table_number)
            ->whereNotNull('mentor_id')
            ->exists();

        if ($conflicts) {
            return back()->withErrors([
                'conflict' => 'The selected time slot and table number is already reserved.',
            ]);
        }

        foreach ($timetables as $attributes) {
            $slot = Timetable::firstOrNew([
                'semester_id' => $attributes['semester_id'],
                'day' => $attributes['day'],
                'time_slot' => $attributes['time_slot'],
                'table_number' => $attributes['table_number'],
                'week_number' => $attributes['week_number'],
            ]);

            $slot->mentor_id = $mentor->id;
            if (! $slot->exists) {
                $slot->reserved = false;
            }
            $slot->save();
        }

        return redirect()->route('mentor.dashboard')
            ->with('success', 'Timetable reserved successfully.');
    }

    private function splitTimeSlot(string $timeSlot): array
    {
        [$start, $end] = explode('-', $timeSlot);

        // Convert to Carbon instances for easier manipulation
        $startTime = \Carbon\Carbon::createFromFormat('H:i', $start);
        $endTime = \Carbon\Carbon::createFromFormat('H:i', $end);

        // Generate two 30-minute slots
        $firstSlot = $startTime->format('H:i').'-'.$startTime->copy()->addMinutes(30)->format('H:i');
        $secondSlot = $startTime->copy()->addMinutes(30)->format('H:i').'-'.$endTime->format('H:i');

        return [$firstSlot, $secondSlot];
    }

    public function checkAvailability(Request $request)
    {
        // Define all possible combinations of days, one-hour time slots, and tables
        $days = Semester::DAYS;
        $timeSlots = Semester::HOUR_SLOTS;
        $semester = Semester::current();

        // Fetch reserved timetables with mentor_id
        $reservedTimetables = Timetable::select('day', 'time_slot', 'table_number', 'mentor_id')
            ->whereNotNull('mentor_id')
            ->distinct()
            ->get()
            ->toArray();

        // Create a list of all timetables with their reserved status and mentor_id
        $availableTimetables = [];
        foreach ($days as $day) {
            foreach ($timeSlots as $timeSlot) {
                // Table count is per day+time slot, per this semester's config.
                $tables = range(1, $semester->tableCapacityForHourSlot($day, $timeSlot));
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
        $mentor = Auth::user()->mentors->first();
        $reservedTimetable = Timetable::where('mentor_id', $mentor->id)->first();

        $students = collect();

        if ($reservedTimetable) {
            $request->validate([
                'week_number' => 'nullable|in:4,5,6,7,8,9,10,11,12,13',
            ]);

            $query = Appointment::whereHas('timetable', function ($q) use ($mentor) {
                $q->where('mentor_id', $mentor->id);
            })->with('student.user');

            if ($request->filled('week_number')) {
                $query->whereHas('timetable', function ($q) use ($request) {
                    $q->where('week_number', $request->week_number);
                });
            }

            $students = $query->get()
                ->pluck('student')
                ->unique('id');
        }

        return view('mentor.timetables.students', compact('students', 'request', 'reservedTimetable'));
    }
}
