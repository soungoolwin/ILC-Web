<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TimetableController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MentorMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\StudentMiddleware;
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


    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});



// Mentor Routes
Route::middleware([MentorMiddleware::class, 'auth'])->group(function () {
    Route::get('/mentor/dashboard', function () {
        return view('components.dashboard');
    })->name('mentor.dashboard');

    Route::get("/mentor/profile", [MentorController::class, 'show'])->name('mentor.profile');
    Route::put('/mentor/profile', [MentorController::class, 'update'])->name('mentor.update');

    //Timetable Routes
    Route::get('/mentor/timetables/reserve', [TimetableController::class, 'create'])->name('mentor.timetables.create');
    Route::post('/mentor/timetables/reserve', [TimetableController::class, 'store'])->name('mentor.timetables.store');

    Route::get('/mentor/timetables/edit', [TimetableController::class, 'edit'])->name('mentor.timetables.edit');
    Route::put('/mentor/timetables/update', [TimetableController::class, 'update'])->name('mentor.timetables.update');

    Route::get('/timetables/availability', [TimetableController::class, 'checkAvailability'])->name('timetables.availability');
});


//Student Routes
Route::middleware([StudentMiddleware::class, 'auth'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('components.dashboard');
    })->name('student.dashboard');

    Route::get("/student/profile", [StudentController::class, 'show'])->name('student.profile');
    Route::put('/student/profile', [StudentController::class, 'update'])->name('student.update');
});


//Admin Routes
Route::middleware([AdminMiddleware::class, 'auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('components.dashboard');
    })->name('admin.dashboard');

    Route::get("/admin/profile", [AdminController::class, 'show'])->name('admin.profile');
    Route::put('/admin/profile', [AdminController::class, 'update'])->name('admin.update');
});


//Logout

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
