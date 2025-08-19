<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Mentor;
use App\Models\Student;
use App\Models\TeamLeader;
use App\Models\User;
use App\Models\RegistrationQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\RegistrationSlotAvailable;


class SignupController extends Controller
{
    protected $maxConcurrentRegistrations = 2;

    public function showStudentRegistrationForm()
    {
        // Set registration-specific session timeout
        config(['session.lifetime' => config('session.registration_lifetime', 15)]);

        // Check queue health before proceeding
        $this->checkQueueHealth();

        // Initialize cache if not set
        if (!cache()->has('active_registrations')) {
            cache()->set('active_registrations', 0);
            cache()->set('queue_position', 0);
            cache()->set('next_in_queue', 1);
        }

        Log::info('Session ID: ' . session()->getId());
        
        // Check if user already has an active registration session
        if (session()->has('registration_status') && session('registration_status') === 'active') {
            Log::info('User has active registration');
            return view('auth.register-student');
        }

        // Get current active registrations
        $currentActive = (int)cache()->get('active_registrations', 0);
        Log::info('Current active registrations: ' . $currentActive);

        if ($currentActive < $this->maxConcurrentRegistrations) {
            // Use atomic operations for incrementing
            $newCount = cache()->increment('active_registrations');
            Log::info('Incremented active count to: ' . $newCount);

            session(['registration_status' => 'active']);
            return view('auth.register-student');
        }

        // Handle waiting queue with strict ordering
        if (!session()->has('queue_position')) {
            $position = cache()->increment('queue_position');
            session(['queue_position' => $position]);
        } else {
            // Get current user's position
            $currentPosition = session('queue_position');
            $nextInQueue = cache()->get('next_in_queue', 1);
            $currentActive = cache()->get('active_registrations', 0);
            
            // Only activate if:
            // 1. This is the next position in queue
            // 2. There's room for more active registrations
            // 3. No one with a lower position number is waiting
            if ($currentPosition === $nextInQueue && 
                $currentActive < $this->maxConcurrentRegistrations &&
                $this->isNextInLine($currentPosition)) {
                
                session(['registration_status' => 'active']);
                cache()->increment('active_registrations');
                return view('auth.register-student');
            }
        }

        $queuePosition = session('queue_position');
        Log::info('Showing queue for position: ' . $queuePosition);

        return view('auth.registration-queue', [
            'position' => $queuePosition
        ]);
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
        // Check queue health before processing registration
        $this->checkQueueHealth();

        // Validate registration status
        if (!session()->has('registration_status') || session('registration_status') !== 'active') {
            return redirect()->route('register.student')
                ->with('error', 'Invalid registration session');
        }

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

        return DB::transaction(function() use ($request, $data) {
            // Create user and student records
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

            // Clear session first
            session()->forget(['registration_status', 'queue_position']);
            
            // Then decrement active count
            cache()->decrement('active_registrations');
            
            Log::info('Registration completed. Active count: ' . cache()->get('active_registrations', 0));

            // Process next in queue
            $this->processNextInQueue();
            $this->cleanupQueuePositions();

            // After successful registration, reset to default session lifetime
            config(['session.lifetime' => env('SESSION_LIFETIME', 120)]);

            return redirect()->route('login')
                ->with('success', 'Student account created successfully!');
        });
    }

    private function isNextInLine($position)
    {
        // Get all active sessions and check if anyone with a lower number is waiting
        $nextInQueue = cache()->get('next_in_queue', 1);
        return $position === $nextInQueue;
    }

    private function processNextInQueue()
    {
        $nextPosition = cache()->get('next_in_queue', 1);
        $lastPosition = cache()->get('queue_position', 0);
        
        if ($nextPosition <= $lastPosition) {
            $currentActive = cache()->get('active_registrations', 0);
            
            if ($currentActive < $this->maxConcurrentRegistrations) {
                // Only increment next_in_queue, let the next refresh handle activation
                cache()->increment('next_in_queue');
                
                // Reset queue if we've reached the end
                if ($nextPosition >= $lastPosition) {
                    cache()->set('next_in_queue', 1);
                    cache()->set('queue_position', 0);
                }
                
                event(new RegistrationSlotAvailable($nextPosition));
            }
        }
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

    private function cleanupQueuePositions()
    {
        // If no active registrations and no one waiting
        if (cache()->get('active_registrations', 0) === 0 && 
            cache()->get('next_in_queue', 1) > cache()->get('queue_position', 0)) {
            
            // Reset all position counters
            cache()->set('next_in_queue', 1);
            cache()->set('queue_position', 0);
            
            Log::info('Queue positions reset');
        }
    }

    private function checkQueueHealth()
    {
        if (!cache()->has('active_registrations')) {
            $this->resetQueueState();
        }
        
        $activeCount = (int)cache()->get('active_registrations', 0);
        $nextInQueue = (int)cache()->get('next_in_queue', 1);
        $queuePosition = (int)cache()->get('queue_position', 0);
        
        if ($activeCount > $this->maxConcurrentRegistrations || 
            $nextInQueue > $queuePosition + 1) {
            $this->resetQueueState();
        }
    }

    private function resetQueueState()
    {
        cache()->set('active_registrations', 0);
        cache()->set('queue_position', 0);
        cache()->set('next_in_queue', 1);
        Log::info('Queue state has been reset');
    }
}
