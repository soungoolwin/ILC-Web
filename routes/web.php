<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MentorMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\StudentMiddleware;
use App\Models\Mentor;
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


    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});



// Mentor Routes
Route::middleware('auth', MentorMiddleware::class)->group(function () {
    Route::get('/mentor/dashboard', function () {
        return view('components.dashboard');
    })->name('mentor.dashboard');

    Route::get('/mentor/profile', function () {
        return view('mentor.profile');
    })->name('mentor.profile');
});


//Student Routes
Route::middleware('auth', StudentMiddleware::class)->group(function () {
    Route::get('/student/dashboard', function () {
        return view('components.dashboard');
    })->name('student.dashboard');

    Route::get('/student/profile', function () {
        return view('student.profile');
    })->name('student.profile');
});


//Admin Routes
Route::middleware(`auth`, AdminMiddleware::class)->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('components.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/profile', function () {
        return view('admin.profile');
    })->name('admin.profile');
});


//Logout

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
