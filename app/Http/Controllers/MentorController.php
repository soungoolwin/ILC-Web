<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MentorController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $mentor = $user->mentors()->first();


        return view('mentor.profile', compact('user', 'mentor'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $mentor = $user->mentors()->first();

        // Validate the request
        $request->validate([
            // Fields from the `users` table
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'line_id' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',

            // Fields from the `mentors` table
            'mentor_id' => 'required|string|unique:mentors,mentor_id,' . $mentor->id,

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

        // Update the `mentors` table
        $mentor->update([
            'mentor_id' => $request->mentor_id,
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

        return redirect()->route('mentor.profile')->with('success', 'Profile updated successfully.');
    }

    public function adminShow($id)
    {
        $mentor = Mentor::with('user')->findOrFail($id); // Fetch mentor with user info
        return view('admin.mentor-profile', compact('mentor'));
    }
}
