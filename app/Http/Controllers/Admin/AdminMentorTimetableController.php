<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Mentor;
use App\Models\Semester;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMentorTimetableController extends Controller
{
    public function edit(Request $request, $mentor_id)
    {
        $mentor = Mentor::with('user')->findOrFail($mentor_id);

        $allTimetables = Timetable::where('mentor_id', $mentor->id)
            ->orderBy('week_number')
            ->orderBy('id')
            ->get();

        if ($allTimetables->isEmpty()) {
            abort(404, 'No timetable found for this mentor.');
        }

        // If admin clicked Edit on a specific row, pre-select that week.
        $focusedTimetable = null;
        if ($request->filled('timetable_id')) {
            $focusedTimetable = $allTimetables->firstWhere('id', (int) $request->timetable_id);
        }

        $defaultScope = $focusedTimetable ? 'week' : 'all';
        $defaultWeek = $focusedTimetable ? (int) $focusedTimetable->week_number : null;
        $timetable = $focusedTimetable ?? $allTimetables->first();

        $weekNumbers = $allTimetables->pluck('week_number')->unique()->sort()->values();

        $capacityMatrix = ($mentor->semester ?? Semester::current())->hourSlotMatrix();

        return view('admin.timetables.mentor-edit', compact(
            'timetable', 'mentor', 'weekNumbers', 'defaultScope', 'defaultWeek', 'capacityMatrix'
        ));
    }

    public function update(Request $request, $mentor_id)
    {
        $mentor = Mentor::findOrFail($mentor_id);

        $request->validate([
            'scope' => 'required|in:all,week',
            'week_number' => 'required_if:scope,week|nullable|integer',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'time_slot' => 'required|in:09:00-10:00,10:00-11:00,11:00-12:00,12:00-13:00,13:00-14:00,14:00-15:00,15:00-16:00,16:00-17:00,17:00-18:00,18:00-19:00,19:00-20:00',
            'table_number' => 'required|integer|between:1,30',
        ]);

        $timeSlots = $this->splitTimeSlot($request->time_slot);

        $capacity = ($mentor->semester ?? Semester::current())->tableCapacityForHourSlot($request->day, $request->time_slot);
        if ($request->table_number > $capacity) {
            return back()->withErrors([
                'conflict' => "Only {$capacity} tables are available for {$request->day} {$request->time_slot}.",
            ])->withInput();
        }

        // Conflict check — scoped to the same week if editing a single week,
        // otherwise across all weeks.
        $conflictQuery = Timetable::where('mentor_id', '!=', $mentor->id)
            ->where('day', $request->day)
            ->where('table_number', $request->table_number)
            ->whereIn('time_slot', $timeSlots);

        if ($request->scope === 'week') {
            $conflictQuery->where('week_number', (string) $request->week_number);
        }

        if ($conflictQuery->exists()) {
            return back()->withErrors([
                'conflict' => 'The selected time slot and table number is already reserved by another mentor.',
            ])->withInput();
        }

        // Fetch the rows to update.
        $query = Timetable::where('mentor_id', $mentor->id);
        if ($request->scope === 'week') {
            $query->where('week_number', (string) $request->week_number);
        }
        $timetables = $query->orderBy('week_number')->orderBy('id')->get();

        if ($timetables->isEmpty()) {
            return back()->withErrors(['error' => 'No reservations found to update.']);
        }

        // Preflight unassigned slots that students may already have booked.
        // They are claimable by this mentor, but the combined bookings must
        // still fit at one table and must not duplicate a student's booking.
        $targets = collect();
        foreach ($timetables->groupBy('week_number') as $rowsInWeek) {
            foreach ($rowsInWeek->values() as $idx => $tt) {
                $targetTimeSlot = $timeSlots[$idx % 2];
                $target = Timetable::whereKeyNot($tt->id)
                    ->whereNull('mentor_id')
                    ->where('week_number', $tt->week_number)
                    ->where('day', $request->day)
                    ->where('time_slot', $targetTimeSlot)
                    ->where('table_number', $request->table_number)
                    ->first();

                if ($target) {
                    $combinedCount = $tt->appointments()->count() + $target->appointments()->count();
                    $sourceStudents = $tt->appointments()->pluck('student_id');
                    $hasDuplicateStudent = $sourceStudents->isNotEmpty()
                        && $target->appointments()->whereIn('student_id', $sourceStudents)->exists();

                    if ($combinedCount > Semester::STUDENTS_PER_SESSION || $hasDuplicateStudent) {
                        return back()->withErrors([
                            'conflict' => 'The selected table already has student bookings that cannot be merged with this mentor shift.',
                        ])->withInput();
                    }
                }

                $targets->push([$tt, $target, $targetTimeSlot]);
            }
        }

        DB::transaction(function () use ($targets, $mentor, $request) {
            foreach ($targets as [$source, $target, $targetTimeSlot]) {
                if ($target) {
                    Appointment::where('timetable_id', $source->id)
                        ->update(['timetable_id' => $target->id]);

                    $source->delete();
                    $target->update([
                        'mentor_id' => $mentor->id,
                        'reserved' => $target->appointments()->count() >= Semester::STUDENTS_PER_SESSION,
                    ]);

                    continue;
                }

                $source->update([
                    'day' => $request->day,
                    'time_slot' => $targetTimeSlot,
                    'table_number' => $request->table_number,
                ]);
            }
        });

        $message = $request->scope === 'week'
            ? "Mentor reservation updated for week {$request->week_number}."
            : 'Mentor reservation updated for all weeks.';

        return redirect()->route('admin.mentor_students_timetable')
            ->with('success', $message);
    }

    private function splitTimeSlot(string $timeSlot): array
    {
        [$start, $end] = explode('-', $timeSlot);

        $startTime = \Carbon\Carbon::createFromFormat('H:i', $start);
        $endTime = \Carbon\Carbon::createFromFormat('H:i', $end);

        $firstSlot = $startTime->format('H:i').'-'.$startTime->copy()->addMinutes(30)->format('H:i');
        $secondSlot = $startTime->copy()->addMinutes(30)->format('H:i').'-'.$endTime->format('H:i');

        return [$firstSlot, $secondSlot];
    }
}
