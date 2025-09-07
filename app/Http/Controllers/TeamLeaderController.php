<?php

namespace App\Http\Controllers;

use App\Models\TeamLeader;
use App\Models\User;
use App\Models\Timetable;
use App\Models\Form;
use App\Models\TeamLeaderForm;
use App\Models\TeamLeaderTimetable;
use App\Models\FileUploadLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class TeamLeaderController extends Controller
{
    /**
     * Show the team leader profile page.
     */
    public function show()
    {
        $user = Auth::user();
        $teamLeader = $user->teamLeaders()->first();

        // Create team leader profile if it doesn't exist
        if (!$teamLeader) {
            // Only try to set columns that exist in the database
            try {
                $teamLeader = TeamLeader::create([
                    'user_id' => $user->id,
                    'teamleader_image' => null,
                ]);
            } catch (\Exception $e) {
                // If columns don't exist, create with minimal data
                $teamLeader = TeamLeader::create([
                    'user_id' => $user->id,
                ]);
            }
        }

        return view('team_leader.profile', compact('user', 'teamLeader'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        $teamLeader = $user->teamLeaders()->first();

        // If teamLeader doesn't exist, create it
        if (!$teamLeader) {
            $teamLeader = TeamLeader::create([
                'user_id' => $user->id,
            ]);
        }

        $timetables = TeamLeaderTimetable::where('team_leader_id', $teamLeader->id)
            ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')")
            ->orderBy('time_slot')
            ->get();

        $username = $user->name;

        return view('team_leader.dashboard', compact('timetables', 'username'));
    }

    //team leader links

    public function links()
    {
        $user = Auth::user();

        // 1) Forms for team leaders, grouped by type
        $forms = Form::where('for_role', 'team_leader')
            ->where('is_active', true)
            ->orderBy('form_type')
            ->orderBy('created_at')
            ->get()
            ->groupBy('form_type');

        // 2) Completion per form id
        $completion = []; // [$type][$formId] = bool
        $teamLeader = $user->teamLeaders()->first();

        if ($teamLeader) {
            foreach ($forms as $type => $formList) {
                foreach ($formList as $form) {
                    $completion[$type][$form->id] = TeamLeaderForm::where('team_leader_id', $teamLeader->id)
                        ->where('form_id', $form->id)
                        ->exists();
                }
            }
        }

        // 3) All upload links for team leaders (we'll match by name in Blade)
        $fileUploadLinks = FileUploadLink::where('for_role', 'team_leader')
            ->orderBy('created_at') // or ->orderBy('name')
            ->get();

        return view('team_leader.links', compact('forms', 'completion', 'fileUploadLinks'));
    }


    /**
     * Update team leader profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $teamLeader = $user->teamLeaders()->first();

        if (!$teamLeader) {
            return redirect()->back()->withErrors(['error' => 'Team leader profile not found.']);
        }

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'line_id' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'faculty' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'team_name' => 'nullable|string|max:255',
            'team_description' => 'nullable|string|max:1000',
            'current_password' => 'nullable|string|min:8',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update the `users` table
        $user->update([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'line_id' => $request->line_id,
            'phone_number' => $request->phone_number,
            'faculty' => $request->faculty,
            'language' => $request->language,
            'level' => $request->level,
        ]);

        // Update the `team_leaders` table - only if columns exist
        try {
            $teamLeader->update([
                'team_name' => $request->team_name,
                'team_description' => $request->team_description,
            ]);
        } catch (\Exception $e) {
            // Skip team leader specific updates if columns don't exist
        }

        // Update password if provided and valid
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('team_leader.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Handle team leader image upload.
     */
    public function uploadImage(Request $request)
    {
        $user = Auth::user();
        $teamLeader = $user->teamLeaders()->first();

        if (!$teamLeader) {
            return redirect()->back()->withErrors(['error' => 'Team leader record not found.']);
        }

        // Validate the uploaded file
        $request->validate([
            'teamleader_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create directory if it doesn't exist
        $uploadPath = public_path('teamleader_image');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Delete the old image if it exists - only if column exists
        try {
            if ($teamLeader->teamleader_image) {
                $oldImagePath = public_path('teamleader_image/' . $teamLeader->teamleader_image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
        } catch (\Exception $e) {
            // Skip if column doesn't exist
        }

        // Generate the new image name using the team leader's nickname
        $nickname = $user->id ?? 'teamleader'; // Fallback to 'teamleader' if nickname is null
        $extension = $request->teamleader_image->getClientOriginalExtension();
        $imageName = $nickname . '_' . time() . '.' . $extension;

        // Move the uploaded file to the public/teamleader_image directory
        $request->teamleader_image->move($uploadPath, $imageName);

        // Update the team leader record with the new image name - only if column exists
        try {
            $teamLeader->update([
                'teamleader_image' => $imageName
            ]);
        } catch (\Exception $e) {
            // Skip if column doesn't exist
        }

        return redirect()->back()->with('success', 'Profile picture updated successfully.');
    }

    public function viewTimetables(Request $request)
    {
        $timetables = Timetable::with(['mentor.user', 'appointments.student.user'])
            ->when($request->filled('week_number'), function ($query) use ($request) {
                $query->where('week_number', $request->week_number);
            })
            ->when($request->filled('day'), function ($query) use ($request) {
                $query->where('day', $request->day);
            })
            ->when($request->filled('time_slot'), function ($query) use ($request) {
                $query->where('time_slot', $request->time_slot);
            })
            ->when($request->filled('table_number'), function ($query) use ($request) {
                $query->where('table_number', $request->table_number);
            })
            ->get()
            ->groupBy(function ($timetable) {
                return $timetable->mentor->user->name ?? 'Unknown Mentor';
            });

        return view('team_leader.view_timetables', compact('timetables', 'request'));
    }



    /* OLD CODE for viewing timetables

    public function viewTimetables(Request $request)
    {
        // Initialize timetables as empty
        $timetables = collect();

        // Only fetch timetables if search criteria are provided
        if ($request->filled('week_number') || $request->filled('day') || $request->filled('time_slot') || $request->filled('table_number')) {
            $timetables = Timetable::with(['mentor.user', 'appointments.student.user'])
                ->when($request->filled('week_number'), function ($query) use ($request) {
                    $query->where('week_number', $request->week_number);
                })
                ->when($request->filled('day'), function ($query) use ($request) {
                    $query->where('day', $request->day);
                })
                ->when($request->filled('time_slot'), function ($query) use ($request) {
                    $query->where('time_slot', $request->time_slot);
                })
                ->when($request->filled('table_number'), function ($query) use ($request) {
                    $query->where('table_number', $request->table_number);
                })
                ->get();
        }

        return view('team_leader.view_timetables', compact('timetables'));
    }
    */

    /**
     * Show team leader profile for admins.
     */
    public function adminShow($id)
    {
        $teamLeader = TeamLeader::with('user')->findOrFail($id);
        return view('admin.team-leader-profile', compact('teamLeader'));
    }

    
}
