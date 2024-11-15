<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Middleware\RedirectIfAuthenticated;
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

//After Login
Route::middleware('auth')->group(function () {
    Route::get('/student/dashboard', function () {
        return view('components.dashboard');
    })->name('student.dashboard');

    Route::get('/mentor/dashboard', function () {
        return view('components.dashboard');
    })->name('mentor.dashboard');

    Route::get('/admin/dashboard', function () {
        return view('components.dashboard');
    })->name('admin.dashboard');
});
//After Login

//Logout

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
