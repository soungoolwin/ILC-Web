<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function create()
    {
        // Fetch available timetables for selection
        $timetables = Timetable::where('reserved', false)
            ->orderBy('week_number')
            ->orderBy('day')
            ->orderBy('time_slot')
            ->get();

        return view('student.appointments.create', compact('timetables'));
    }

    public function store(Request $request)
    {
        $student = Auth::user()->students()->first();

        // Validate input
        $request->validate([
            'week_number' => 'required|integer|min:1|max:16',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'time_slot' => 'required|string|regex:/^\d{2}:\d{2}-\d{2}:\d{2}$/', // Format: HH:MM-HH:MM
            'table_number' => 'required|integer|min:1|max:25',
        ]);

        // Find the timetable record
        $timetable = Timetable::where('week_number', $request->week_number)
            ->where('day', $request->day)
            ->where('time_slot', $request->time_slot)
            ->where('table_number', $request->table_number)
            ->first();

        if (!$timetable) {
            return back()->withErrors(['error' => 'The selected timetable does not exist.']);
        }

        // Check if the student has already booked this timetable
        $existingAppointment = Appointment::where('timetable_id', $timetable->id)
            ->where('student_id', $student->id)
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(['error' => 'You have already booked this time slot.']);
        }

        // Check if the timetable is already fully booked (5 students)
        $appointmentCount = Appointment::where('timetable_id', $timetable->id)->count();

        if ($appointmentCount >= 5) {
            return back()->withErrors(['error' => 'This time slot is already fully booked.']);
        }

        // Create the appointment
        Appointment::create([
            'student_id' => $student->id,
            'timetable_id' => $timetable->id,
        ]);

        // Recheck if the timetable has reached 5 appointments after inserting
        $updatedAppointmentCount = Appointment::where('timetable_id', $timetable->id)->count();

        if ($updatedAppointmentCount >= 5) {
            $timetable->update(['reserved' => true]);
        }

        return redirect()->route('student.dashboard')->with('success', 'Appointment created successfully.');
    }

    public function checkAvailability(Request $request)
    {

        // Fetch all timetables grouped by week, day, and time slot
        $query = Timetable::query();

        // Apply search filters
        if ($request->filled('week_number')) {
            $query->where('week_number', $request->week_number);
        }
        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }
        if ($request->filled('time_slot')) {
            $query->where('time_slot', $request->time_slot);
        }
        if ($request->filled('table_number')) {
            $query->where('table_number', $request->table_number);
        }

        // Fetch timetables with reserved status
        $availableTimetables = $query->orderBy('week_number')
            ->orderBy('day')
            ->orderBy('time_slot')
            ->get()
            ->map(function ($timetable) {
                return [
                    'week_number' => $timetable->week_number,
                    'day' => $timetable->day,
                    'time_slot' => $timetable->time_slot,
                    'table_number' => $timetable->table_number,
                    'is_reserved' => $timetable->reserved ? 'Reserved' : 'Available',
                    'mentor' => $timetable->mentor->user->name ?? 'N/A',
                    'mentor_id' => $timetable->mentor->id ?? null,
                ];
            });

        return view('student.appointments.availability', compact('availableTimetables', 'request'));
    }
}
