<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GuestPageController extends Controller
{
    public function showStats()
    {
        $totalUsers = User::count();
        $totalMentors = User::whereHas('mentors')->count();
        $totalTeamLeaders = User::whereHas('teamLeaders')->count();
        $totalStudents = User::whereHas('students')->count();

        // Data is passed here. If the route points here, the view WILL receive these variables.
        return view('guest', compact('totalUsers', 'totalMentors', 'totalTeamLeaders', 'totalStudents'));
    }
}