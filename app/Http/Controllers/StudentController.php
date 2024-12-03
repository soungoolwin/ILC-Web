<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $student = $user->students()->first();


        return view('student.profile', compact('user', 'student'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $student = $user->students()->first();

        // Validate the request
        $request->validate([
            // Fields from the `users` table
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'line_id' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',

            // Fields from the `students` table
            'student_id' => 'required|string|unique:students,student_id,' . $student->id,

            // Password fields
            'current_password' => 'nullable|string|min:8',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update the `users` table
        $user->update([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'line_id' => $request->line_id,
            'phone_number' => $request->phone_number,
        ]);

        // Update the `students` table
        $student->update([
            'student_id' => $request->student_id,
        ]);

        // Update password if provided and valid
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully.');
    }

    public function adminShow($id)
    {
        $student = Student::with('user')->findOrFail($id); // Fetch student with user info
        return view('admin.student-profile', compact('student'));
    }
}
