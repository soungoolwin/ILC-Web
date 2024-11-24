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
}
