<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Semester;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function create()
    {
        $capacityMatrix = Semester::current()->halfHourSlotMatrix();
        $maxTableCapacity = collect($capacityMatrix)->flatten()->max();

        return view('student.appointments.create', compact('capacityMatrix', 'maxTableCapacity'));
    }

    public function store(Request $request)
    {
        $student = Auth::user()->students()->first();

        // Validate input
        $request->validate([
            'week_number' => 'required|integer|min:1|max:16',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'time_slot' => ['required', Rule::in(Semester::HALF_HOUR_SLOTS)],
            'table_number' => 'required|integer|min:1|max:30',
        ]);

        $semester = $student->semester ?? Semester::current();
        $capacity = $semester->tableCapacityForHalfHourSlot($request->day, $request->time_slot);

        if ($request->integer('table_number') > $capacity) {
            return back()->withErrors([
                'table_number' => "Only {$capacity} tables are available for {$request->day} {$request->time_slot}.",
            ])->withInput();
        }

        // only 4 appointments per week
        $weeklyCount = Appointment::where('student_id', $student->id)
            ->whereHas('timetable', function ($query) use ($request) {
                $query->where('week_number', $request->week_number);
            })
            ->count();

        if ($weeklyCount >= 4) {
            return back()->withErrors([
                'error' => "You already have 4 appointments in week {$request->week_number}.",
            ]);
        }

        // A student books a physical table slot, not a mentor's shift. Reuse
        // the mentor timetable when one exists; otherwise create an
        // unassigned slot so every configured time remains bookable.
        $timetable = Timetable::firstOrCreate([
            'semester_id' => $student->semester_id,
            'week_number' => (string) $request->week_number,
            'day' => $request->day,
            'time_slot' => $request->time_slot,
            'table_number' => $request->integer('table_number'),
        ], [
            'mentor_id' => null,
            'reserved' => false,
        ]);

        // Check if the student has already booked this timetable
        $existingAppointment = Appointment::where('timetable_id', $timetable->id)
            ->where('student_id', $student->id)
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(['error' => 'You have already booked this time slot.']);
        }

        // Check if the timetable is already fully booked (5 students)
        /* ! Change the student limit per mentor here ! */
        $appointmentCount = Appointment::where('timetable_id', $timetable->id)->count();

        if ($appointmentCount >= Semester::STUDENTS_PER_SESSION) {
            return back()->withErrors(['error' => 'This time slot is already fully booked.']);
        }

        // Create the appointment
        Appointment::create([
            'student_id' => $student->id,
            'semester_id' => $student->semester_id,
            'timetable_id' => $timetable->id,
        ]);

        // Recheck if the timetable has reached 5 appointments after inserting
        /* ! Change the student limit per mentor here ! */
        $updatedAppointmentCount = Appointment::where('timetable_id', $timetable->id)->count();

        if ($updatedAppointmentCount >= Semester::STUDENTS_PER_SESSION) {
            $timetable->update(['reserved' => true]);
        }

        return redirect()->route('student.dashboard')->with('success', 'Appointment created successfully.');
    }

    public function edit($id)
    {
        $appointment = Appointment::with('timetable')->findOrFail($id);

        $student = Auth::user()->students()->first();

        if (! $student || $student->id !== $appointment->student_id) {
            abort(403, 'Unauthorized action.');
        }

        $capacityMatrix = Semester::current()->halfHourSlotMatrix();
        $maxTableCapacity = collect($capacityMatrix)->flatten()->max();

        return view('student.appointments.edit', compact('appointment', 'capacityMatrix', 'maxTableCapacity'));
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::with('timetable')->findOrFail($id);
        $student = Auth::user()->students()->first();

        if (! $student || $student->id !== $appointment->student_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'week_number' => 'required|integer|min:1|max:16',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'time_slot' => ['required', Rule::in(Semester::HALF_HOUR_SLOTS)],
            'table_number' => 'required|integer|min:1|max:30',
        ]);

        $semester = $student->semester ?? Semester::current();
        $capacity = $semester->tableCapacityForHalfHourSlot($request->day, $request->time_slot);

        if ($request->integer('table_number') > $capacity) {
            return back()->withErrors([
                'table_number' => "Only {$capacity} tables are available for {$request->day} {$request->time_slot}.",
            ])->withInput();
        }

        $weeklyCount = Appointment::where('student_id', $student->id)
            ->where('id', '!=', $appointment->id)
            ->whereHas('timetable', function ($query) use ($request) {
                $query->where('week_number', $request->week_number);
            })
            ->count();

        if ($weeklyCount >= 4) {
            return back()->withErrors([
                'error' => "You already have 4 appointments in week {$request->week_number}.",
            ]);
        }

        // Save the old timetable BEFORE changing it
        $oldTimetable = $appointment->timetable;

        $timetable = Timetable::firstOrCreate([
            'semester_id' => $student->semester_id,
            'week_number' => (string) $request->week_number,
            'day' => $request->day,
            'time_slot' => $request->time_slot,
            'table_number' => $request->integer('table_number'),
        ], [
            'mentor_id' => null,
            'reserved' => false,
        ]);

        // Check for duplicate booking (excluding current appointment)
        $duplicate = Appointment::where('timetable_id', $timetable->id)
            ->where('student_id', $student->id)
            ->where('id', '!=', $appointment->id)
            ->first();

        if ($duplicate) {
            return back()->withErrors(['error' => 'You have already booked this time slot.']);
        }

        // Check if the new slot is already full (5 limit)
        $count = Appointment::where('timetable_id', $timetable->id)
            ->where('id', '!=', $appointment->id)
            ->count();

        if ($count >= Semester::STUDENTS_PER_SESSION) {
            return back()->withErrors(['error' => 'This time slot is already fully booked.']);
        }

        // Update appointment
        $appointment->timetable_id = $timetable->id;
        $appointment->save();

        // Clean up old timetable if it exists
        if ($oldTimetable && $oldTimetable->id !== $timetable->id) {
            $oldCount = Appointment::where('timetable_id', $oldTimetable->id)->count();
            if ($oldCount < Semester::STUDENTS_PER_SESSION) {
                $oldTimetable->update(['reserved' => false]);
            }
        }

        // Reserve new if it's now full
        if ($count + 1 >= Semester::STUDENTS_PER_SESSION) {
            $timetable->update(['reserved' => true]);
        }

        return redirect()->route('student.dashboard')->with('success', 'Appointment updated successfully.');
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'week_number' => 'nullable|integer|between:4,13',
            'day' => ['nullable', Rule::in(Semester::DAYS)],
            'time_slot' => ['nullable', Rule::in(Semester::HALF_HOUR_SLOTS)],
            'table_number' => 'nullable|integer|min:1|max:30',
        ]);

        $semester = Semester::current();
        $capacityMatrix = $semester->halfHourSlotMatrix();
        $maxTableCapacity = collect($capacityMatrix)->flatten()->max();
        $weeks = $request->filled('week_number') ? [$request->integer('week_number')] : range(4, 13);
        $days = $request->filled('day') ? [$request->day] : Semester::DAYS;
        $timeSlots = $request->filled('time_slot') ? [$request->time_slot] : Semester::HALF_HOUR_SLOTS;

        $existingSlots = Timetable::with(['mentor.user'])
            ->withCount('appointments')
            ->whereIn('week_number', array_map('strval', $weeks))
            ->whereIn('day', $days)
            ->whereIn('time_slot', $timeSlots)
            ->get()
            ->keyBy(fn (Timetable $slot) => $this->slotKey(
                $slot->week_number,
                $slot->day,
                $slot->time_slot,
                $slot->table_number
            ));

        $slots = collect();
        foreach ($weeks as $week) {
            foreach ($days as $day) {
                foreach ($timeSlots as $timeSlot) {
                    $capacity = $semester->tableCapacityForHalfHourSlot($day, $timeSlot);
                    $tables = $request->filled('table_number')
                        ? [$request->integer('table_number')]
                        : ($capacity > 0 ? range(1, $capacity) : []);

                    foreach ($tables as $table) {
                        if ($table > $capacity) {
                            continue;
                        }

                        $slot = $existingSlots->get($this->slotKey($week, $day, $timeSlot, $table));
                        $booked = $slot?->appointments_count ?? 0;
                        $remaining = max(0, Semester::STUDENTS_PER_SESSION - $booked);

                        $slots->push([
                            'week_number' => $week,
                            'day' => $day,
                            'time_slot' => $timeSlot,
                            'table_number' => $table,
                            'is_reserved' => $remaining === 0
                                ? 'Full'
                                : "Available ({$remaining} spots left)",
                            'mentor' => $slot?->mentor?->user?->name ?? 'Not assigned',
                            'mentor_id' => $slot?->mentor_id,
                        ]);
                    }
                }
            }
        }

        $page = LengthAwarePaginator::resolveCurrentPage();
        $availableTimetables = new LengthAwarePaginator(
            $slots->forPage($page, 100)->values(),
            $slots->count(),
            100,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('student.appointments.availability', compact(
            'availableTimetables', 'capacityMatrix', 'maxTableCapacity', 'request'
        ));
    }

    private function slotKey(int|string $week, string $day, string $timeSlot, int|string $table): string
    {
        return implode('|', [$week, $day, $timeSlot, $table]);
    }
}
