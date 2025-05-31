<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Mentor;
use App\Models\Student;
use App\Models\TeamLeader;
use App\Models\User;
use Illuminate\Http\Request;

class SignupController extends Controller
{
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
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'line_id' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'student_id' => 'required|string|unique:students,student_id',
            'faculty' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'level' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']), // Use bcrypt for hashing
            'role' => 'student',
            'line_id' => $data['line_id'],
            'phone_number' => $data['phone_number'],
            'faculty' => $data['faculty'],
            'language' => $data['language'],
            'level' => $data['level'],
        ]);

        Student::create([
            'user_id' => $user->id,
            'student_id' => $data['student_id'],
        ]);

        return redirect()->route('login')->with('success', 'Student account created successfully!');
    }

    /**
     * Handle mentor registration.
     */
    public function registerMentor(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'line_id' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'mentor_id' => 'required|string|unique:mentors,mentor_id',
            'faculty' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'level' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']), // Use bcrypt for hashing
            'role' => 'mentor',
            'line_id' => $data['line_id'],
            'phone_number' => $data['phone_number'],
            'faculty' => $data['faculty'],
            'language' => $data['language'],
            'level' => $data['level'],
        ]);

        Mentor::create([
            'user_id' => $user->id,
            'mentor_id' => $data['mentor_id'],
        ]);

        return redirect()->route('login')->with('success', 'Mentor account created successfully!');
    }


    public function registerAdmin(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'line_id' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'admin_id' => 'required|string|unique:admins,admin_id',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']), // Use bcrypt for hashing
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
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'line_id' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'team_leader_id' => 'required|string|unique:team_leaders,team_leader_id',
            'faculty' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'level' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']), // Use bcrypt for hashing
            'role' => 'team_leader',
            'line_id' => $data['line_id'],
            'phone_number' => $data['phone_number'],
            'faculty' => $data['faculty'],
            'language' => $data['language'],
            'level' => $data['level'],
        ]);

        TeamLeader::create([
            'user_id' => $user->id,
            'team_leader_id' => $data['team_leader_id'],
        ]);

        return redirect()->route('login')->with('success', 'Team Leader account created successfully!');
    }
}
