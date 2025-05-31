<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'line_id' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'mentor_id' => 'required|string|unique:mentors,mentor_id,' . $mentor->id,
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

    public function uploadImage(Request $request)
    {
        $user = Auth::user();
        $mentor = $user->mentors()->first();

        if (!$mentor) {
            return redirect()->back()->withErrors(['error' => 'Mentor record not found.']);
        }

        // Validate the uploaded file
        $request->validate([
            'mentor_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Delete the old image if it exists
        if ($mentor->mentor_image) {
            Storage::delete('mentor_image/' . $mentor->mentor_image);
        }

        // Generate the new image name using the mentor's nickname
        $nickname = $user->nickname ?? 'mentor'; // Fallback to 'mentor' if nickname is null
        $imageName = $nickname . '.jpg';

        // Move the uploaded file to the public/mentor_image directory
        $request->mentor_image->move(public_path('mentor_image'), $imageName);

        // Update the mentor record with the new image name
        $mentor->mentor_image = $imageName;
        $mentor->save();

        return redirect()->back()->with('success', 'Profile picture updated successfully.');
    }

    public function status_check($user)
    {
        $mentor = Auth::$user()->mentors()->first();
        return $mentor->status;
    }

    public function adminShow($id)
    {
        $mentor = Mentor::with('user')->findOrFail($id); // Fetch mentor with user info
        return view('admin.mentor-profile', compact('mentor'));
    }

    public function teamLeaderShow($id)
    {
        $mentor = Mentor::with('user')->findOrFail($id);
        return view('team_leader.mentor-profile', compact('mentor'));
    }

    public function studentShow($id)
    {
        $mentor = Mentor::with('user')->findOrFail($id); // Fetch mentor with user info
        return view('student.mentor-profile', compact('mentor'));
    }

    /**
     * Handle mentor confirmation for the next semester.
     */
    public function confirmNextSemester(Request $request)
    {
        $user = Auth::user();
        $mentor = $user->mentors()->first();

        if (!$mentor) {
            return redirect()->route('mentor.profile')->withErrors(['error' => 'Mentor profile not found.']);
        }

        // Check the user's response
        if ($request->input('confirm') === 'yes') {
            // Increment mentor_sem, set status to active, and redirect to dashboard
            $mentor->increment('mentor_sem');
            $mentor->update([
                'status' => 'active',
                'last_checked_at' => Carbon::now(),
            ]);

            return redirect()->route('mentor.dashboard')->with('success', 'You have confirmed to be a mentor for the next semester.');
        } else {
            // Set status to paused and redirect to the paused page
            $mentor->update([
                'status' => 'paused',
                'last_checked_at' => Carbon::now(),
            ]);

            return $this->pause();
        }
    }

    public function pause()
    {
        $user = Auth::user();
        $mentor = $user->mentors()->first();

        if (!$mentor) {
            return redirect()->route('mentor.profile')->withErrors(['error' => 'Mentor profile not found.']);
        }

        return view('mentor.pause', compact('mentor'));
    }

    public function nextSemester(Mentor $mentor)
    {
        // Add your logic for handling the next semester
        return view('mentor.nextsem', compact('mentor'));
    }
}