<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Mentor;
use App\Models\Semester;
use App\Models\Student;
use App\Models\TeamLeader;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SignupController extends Controller
{
    /**
     * Find an existing user by email for the given role, or create a new
     * one. Returning participants keep their user account across
     * semesters instead of being blocked by a unique-email check.
     */
    private function findOrCreateUser(array $data, string $role, string $idField): User
    {
        $existing = User::where('email', $data['email'])->first();

        if ($existing) {
            abort_if($existing->role !== $role, 422, 'This email is already registered under a different role.');

            return $existing;
        }

        return User::create([
            'name' => $data['name'],
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => bcrypt($data[$idField]),
            'role' => $role,
            'line_id' => $data['line_id'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'faculty' => $data['faculty'] ?? null,
            'language' => $data['language'] ?? null,
            'level' => $data['level'] ?? null,
        ]);
    }

    public function showStudentRegistrationForm()
    {
        return view('auth.register-student'); // Create this Blade view
    }

    /**
     * Show the mentor registration form.
     */
    public function showMentorRegistrationForm()
    {
        return view('auth.register-mentor'); // Create this Blade view
    }

    public function showAdminRegistrationForm()
    {
        return view('auth.register-admin'); // Create this Blade view
    }

    /**
     * Handle student registration.
     */
    public function registerStudent(Request $request)
    {
        $semester = Semester::current();

        if (!$semester) {
            return back()->withErrors(['error' => 'No active semester is set up yet. Contact an admin.'])->withInput();
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'student_id' => [
                'required', 'string',
                Rule::unique('students', 'student_id')->where('semester_id', $semester->id),
            ],
            'id_confirmation' => 'required|string|same:student_id',
        ]);

        $user = $this->findOrCreateUser($data, 'student', 'student_id');

        Student::create([
            'user_id' => $user->id,
            'semester_id' => $semester->id,
            'student_id' => $data['student_id'],
        ]);

        return redirect()->route('login')->with('success', 'Student account created successfully!');
    }

    /**
     * Handle mentor registration.
     */
    public function registerMentor(Request $request)
    {
        $semester = Semester::current();

        if (!$semester) {
            return back()->withErrors(['error' => 'No active semester is set up yet. Contact an admin.'])->withInput();
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|ends_with:@rsu.ac.th',
            //'password' => 'required|string|min:8|confirmed',
            'line_id' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'mentor_id' => [
                'required', 'string',
                Rule::unique('mentors', 'mentor_id')->where('semester_id', $semester->id),
            ],
            'faculty' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'men_id_confirmation' => 'required|string|same:mentor_id',
        ],[
            'email.ends_with' => 'The email must be a valid rsu.ac.th address.',
        ]);

        $user = $this->findOrCreateUser($data, 'mentor', 'mentor_id');

        Mentor::create([
            'user_id' => $user->id,
            'semester_id' => $semester->id,
            'mentor_id' => $data['mentor_id'],
        ]);

        return redirect()->route('login')->with('success', 'Mentor account created successfully!');
    }


    public function registerAdmin(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|ends_with:@rsu.ac.th',
            //'password' => 'required|string|min:8|confirmed',
            'line_id' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'admin_id' => 'required|string|unique:admins,admin_id',
            'adm_id_confirmation' => 'required|string|same:admin_id',
        ],[
            'email.ends_with' => 'The email must be a valid rsu.ac.th address.',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => bcrypt($data['admin_id']), // Use bcrypt for hashing
            'role' => 'admin',
            'line_id' => $data['line_id'],
            'phone_number' => $data['phone_number'],
        ]);


        $admin = Admin::create([
            'user_id' => $user->id,
            'admin_id' => $data['admin_id'],
        ]);


        return redirect()->route('login')->with('success', 'Admin account created successfully!');
    }


    public function showTeamLeaderRegistrationForm()
    {
        return view('auth.register-team-leader'); // Create this Blade view
    }

    public function registerTeamLeader(Request $request)
    {
        $semester = Semester::current();

        if (!$semester) {
            return back()->withErrors(['error' => 'No active semester is set up yet. Contact an admin.'])->withInput();
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|ends_with:@rsu.ac.th',
            //'password' => 'required|string|min:8|confirmed',
            'line_id' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'team_leader_id' => [
                'required', 'string',
                Rule::unique('team_leaders', 'team_leader_id')->where('semester_id', $semester->id),
            ],
            'faculty' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'tl_id_confirmation' => 'required|string|same:team_leader_id',
        ],[
            'email.ends_with' => 'The email must be a valid rsu.ac.th address.',
        ]);

        $user = $this->findOrCreateUser($data, 'team_leader', 'team_leader_id');

        TeamLeader::create([
            'user_id' => $user->id,
            'semester_id' => $semester->id,
            'team_leader_id' => $data['team_leader_id'],
        ]);

        return redirect()->route('login')->with('success', 'Team Leader account created successfully!');
    }
}
