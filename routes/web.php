<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeamLeaderController;
use App\Http\Controllers\TeamLeaderFormController;
use App\Http\Controllers\TeamLeaderTimetableController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\AdminFormController;
use App\Http\Controllers\StudentFormController;
use App\Http\Controllers\MentorFormController;
use App\Http\Controllers\AdminFileUploadLinkController;
use App\Http\Controllers\AttendanceController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MentorMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\StudentMiddleware;
use App\Http\Middleware\TeamLeaderMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('test');
});

// Authentication Routes
Route::middleware(RedirectIfAuthenticated::class)->group(function () {

    Route::get('/register/student', [SignupController::class, 'showStudentRegistrationForm'])->name('register.student');
    Route::post('/register/student', [SignupController::class, 'registerStudent']);

    Route::get('/register/mentor', [SignupController::class, 'showMentorRegistrationForm'])->name('register.mentor');
    Route::post('/register/mentor', [SignupController::class, 'registerMentor']);

    Route::get('/register/admin', [SignupController::class, 'showAdminRegistrationForm'])->name('register.admin');
    Route::post('/register/admin', [SignupController::class, 'registerAdmin']);

    Route::get('/register/team-leader', [SignupController::class, 'showTeamLeaderRegistrationForm'])->name('register.team_leader');
    Route::post('/register/team-leader', [SignupController::class, 'registerTeamLeader']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');


});



// Mentor Routes
Route::middleware([MentorMiddleware::class, 'auth'])->group(function () {
    Route::get('/mentor/dashboard', function () {
        return view('mentor.dashboard');
    })->name('mentor.dashboard');

    // Mentor Links
    Route::get('/mentor/links', [MentorController::class, 'links'])->name('mentor.links');
    Route::post('/mentor/links/{form}/complete', [MentorFormController::class, 'complete'])->name('mentor.forms.complete');
    Route::delete('/mentor/links/{form}/undo', [MentorFormController::class, 'undo'])->name('mentor.forms.undo');

    // Mentor Profile Management
    Route::get("/mentor/profile", [MentorController::class, 'show'])->name('mentor.profile');
    Route::put('/mentor/profile', [MentorController::class, 'update'])->name('mentor.update');

    Route::post('/mentor/image/upload', [MentorController::class, 'uploadImage'])->name('mentor.image.upload');

    //Timetable Routes
    Route::get('/mentor/timetables/reserve', [TimetableController::class, 'create'])->name('mentor.timetables.create');
    Route::post('/mentor/timetables/reserve', [TimetableController::class, 'store'])->name('mentor.timetables.store');

    Route::get('/mentor/timetables/edit', [TimetableController::class, 'edit'])->name('mentor.timetables.edit');
    Route::put('/mentor/timetables/update', [TimetableController::class, 'update'])->name('mentor.timetables.update');

    Route::get('/timetables/availability', [TimetableController::class, 'checkAvailability'])->name('timetables.availability');

    Route::get('/mentor/timetables/students', [TimetableController::class, 'searchStudents'])->name('mentor.timetables.students');


    Route::get('/mentor/nextsem/{mentor}', [MentorController::class, 'nextSemester'])->name('mentor.nextsem');
    //Route for mentor checker
    Route::post('/mentor/confirm-next-semester', [MentorController::class, 'confirmNextSemester'])->name('mentor.confirmNextSemester');
    // Mentor suspend and pause routes
    Route::get('/mentor/pause', [MentorController::class, 'pause'])->name('mentor.pause');
    Route::get('/mentor/suspended', [MentorController::class, 'suspended'])->name('mentor.suspended');
    // Route for mentors viewing student profile
    Route::get('/mentor/students/{id}', [StudentController::class, 'mentorShow'])->name('mentor.students.show');
});


//Student Routes
Route::middleware([StudentMiddleware::class, 'auth'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

    // Team Leader Consent Links
    Route::get('/student/links', [StudentController::class, 'links'])->name('student.links');
    Route::post('/student/links/{form}/complete', [StudentFormController::class, 'complete'])->name('student.forms.complete');
    Route::delete('/student/links/{form}/undo', [StudentFormController::class, 'undo'])->name('student.forms.undo');

    // Student Profile Management
    Route::get("/student/profile", [StudentController::class, 'show'])->name('student.profile');
    Route::put('/student/profile', [StudentController::class, 'update'])->name('student.update');

    Route::get('/student/mentors/{id}', [MentorController::class, 'studentShow'])->name('student.mentors.show');

    Route::get('/student/appointments/create', [AppointmentController::class, 'create'])->name('student.appointments.create');
    Route::post('/student/appointments/store', [AppointmentController::class, 'store'])->name('student.appointments.store');
    Route::get('/student/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('student.appointments.edit');
    Route::put('/student/appointments/{appointment}', [AppointmentController::class, 'update'])->name('student.appointments.update');

    Route::get('/student/appointments/availability', [AppointmentController::class, 'checkAvailability'])->name('student.appointments.availability');
});


//Admin Routes
Route::middleware([AdminMiddleware::class, 'auth'])->group(function () {
    Route::get('/admin/dashboard', action: function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get("/admin/profile", [AdminController::class, 'show'])->name('admin.profile');
    Route::put('/admin/profile', [AdminController::class, 'update'])->name('admin.update');

    //to check timetable of team leader
    Route::get('/admin/team-leaders-timetables', [AdminController::class, 'viewTeamLeadersTimetable'])->name('admin.team_leaders_timetable');

    //to check timetable of mentor-student timetable
    Route::get('/admin/mentor-students-timetable', [AdminController::class, 'viewMentorStudentsTimetable'])->name('admin.mentor_students_timetable');

    // Admin see all users and delete
    Route::get('/admin/users/index', [AdminController::class, 'viewUsers'])->name('admin.users.index'); // View all users
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete'); // Delete a user

    //See Profiles
    Route::get('/admin/mentors/{id}', [MentorController::class, 'adminShow'])->name('admin.mentors.show');
    Route::get('/admin/students/{id}', [StudentController::class, 'adminShow'])->name('admin.students.show');
    Route::get('/admin/team-leaders/{id}', [TeamLeaderController::class, 'adminShow'])->name('admin.team_leaders.show');

    // Admin Forms
    // Display a list of forms
    Route::get('admin/forms', [AdminFormController::class, 'index'])->name('admin.forms.index');

    // Show the form for creating a new form
    Route::get('admin/forms/create', [AdminFormController::class, 'create'])->name('admin.forms.create');

    // Store a newly created form
    Route::post('admin/forms', [AdminFormController::class, 'store'])->name('admin.forms.store');

    // Show the form for editing the specified form
    Route::get('admin/forms/{form}/edit', [AdminFormController::class, 'edit'])->name('admin.forms.edit');

    // Update the specified form in the database
    Route::put('admin/forms/{form}', [AdminFormController::class, 'update'])->name('admin.forms.update');

    // Delete the specified form
    Route::delete('admin/forms/{form}', [AdminFormController::class, 'destroy'])->name('admin.forms.destroy');

    // Display the details of a specific form
    Route::get('admin/forms/{form}', [AdminFormController::class, 'show'])->name('admin.forms.show');

    //Admin Form Tracking
    Route::get('/admin/form-tracking', [AdminFormController::class, 'tracking'])->name('admin.forms.tracking');

    Route::get('/admin/file_upload_links/create', [AdminFileUploadLinkController::class, 'create'])->name('admin.file_upload_links.create');

    // Admin File Upload Links
    Route::post('/admin/file_upload_links', [AdminFileUploadLinkController::class, 'store'])->name('admin.file_upload_links.store');

    Route::get('/admin/file_upload_links/{file_upload_link}', [AdminFileUploadLinkController::class, 'show'])->name('admin.file_upload_links.show');

    Route::get('/admin/file_upload_links/{file_upload_link}/edit', [AdminFileUploadLinkController::class, 'edit'])->name('admin.file_upload_links.edit');

    Route::put('/admin/file_upload_links/{file_upload_link}', [AdminFileUploadLinkController::class, 'update'])->name('admin.file_upload_links.update');

    Route::delete('/admin/file_upload_links/{file_upload_link}', [AdminFileUploadLinkController::class, 'destroy'])->name('admin.file_upload_links.destroy');

    Route::get('/admin/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::post('/admin/attendance/preview', [AttendanceController::class, 'preview'])->name('admin.attendance.preview');


});

//Team Leader Routes
Route::middleware([TeamLeaderMiddleware::class, 'auth'])->group(function () {
    Route::get('/team-leader/dashboard', [TeamLeaderController::class, 'dashboard'])->name('team_leader.dashboard');

    // Team Leader Consent Links
    Route::get('/team-leader/links', [TeamLeaderController::class, 'links'])->name('team_leader.links');
    Route::post('/team-leader/links/{form}', [TeamLeaderFormController::class, 'markCompleted'])->name('team_leader.forms.complete');
    Route::delete('/team-leader/links/{form}/undo', [TeamLeaderFormController::class, 'undo'])->name('team_leader.forms.undo');

    // Team Leader Timetable Management
    Route::get('/team-leader/view-timetables', [TeamLeaderController::class, 'viewTimetables'])->name('team_leader.view_timetables');

    Route::get('/team-leader/profile', [TeamLeaderController::class, 'show'])->name('team_leader.profile');
    Route::put('/team-leader/profile', [TeamLeaderController::class, 'update'])->name('team_leader.update');

    //for reserve their timetables
    Route::get('/team-leader/timetable', [TeamLeaderTimetableController::class, 'create'])->name('team_leader.timetable.create');
    Route::post('/team-leader/timetable', [TeamLeaderTimetableController::class, 'store'])->name('team_leader.timetable.store');

    //Check Availability
    Route::get('/team-leader/timetable/availability', [TeamLeaderTimetableController::class, 'checkAvailability'])
        ->name('team_leader.timetable.availability');

    Route::post('/team-leader/image/upload', [TeamLeaderController::class, 'uploadImage'])->name('team_leader.image.upload');

    // Team Leader Viewing Student and Mentor Profiles
    Route::get('/team-leader/students/{id}', [StudentController::class, 'teamLeaderShow'])->name('team_leader.students.show');
    Route::get('/team-leader/mentors/{id}', [MentorController::class, 'teamLeaderShow'])->name('team_leader.mentors.show');
});

Route:: get('test', function () {
    return view('test');
})->name('test');

Route::get('/components/newsletter', function () {
    return view('components.newsletter');
})->name('newsletter');

//Logout

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
