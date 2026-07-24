<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0 final-scale=1.0 user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <title>RSU GLOBAL! PAL Center</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-white">
    <div class="min-h-screen flex-col">
        <!-- Header with Logo and Title -->
        <header class="fixed top-0 z-50 w-full bg-white py-2 shadow-sm backdrop-blur-sm">
            <!-- Navigation Bar with Login/Register -->

            <div
                class="gap-xs mr-2 flex w-full justify-between px-1 py-1 text-[10px] md:text-sm lg:gap-2 lg:px-4 lg:py-2 lg:text-base">
                <div class="items-left flex justify-center gap-1 text-left">
                    <img src="/images/rsuGlobal.png" alt="RSU Logo" class="h-10 w-10 md:h-12 md:w-12" />
                    <h1 class="mx-auto text-sm font-bold tracking-wider text-[#7D3C98] md:text-base lg:text-2xl">
                        RSU GLOBAL!
                        <span
                            class="mt-[-4px] block text-xs font-normal tracking-normal text-gray-600 md:text-sm lg:text-xs">
                            PAL Center
                        </span>
                    </h1>
                </div>

                @if (Auth::check())
                    @if (Auth::user()->role === 'student')
                        @php
                            $appointment = null;
                            $student = Auth::user()->students()->first();
                            if ($student) {
                                $appointment = \App\Models\Appointment::where('student_id', $student->id)
                                    ->latest()
                                    ->first();
                            }
                        @endphp

                        <div class="flex items-center gap-2">
                            <a href="{{ route('student.dashboard') }}"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Home
                            </a>
                            <a href="{{ route('newsletter') }}"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Portal
                            </a>
                            <!-- Appointments Dropdown -->
                            <button id="dropdownButton"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white focus:outline-none lg:px-4 lg:py-2">
                                Appointments
                            </button>
                            <div id="dropdownMenu"
                                class="absolute right-[120px] top-[120px] z-10 mt-2 hidden w-48 w-fit rounded-md border border-gray-300 bg-white text-xs shadow-xl lg:right-[180px] lg:top-[130px] lg:mt-3 lg:text-sm">
                                <a href="{{ route('student.appointments.availability') }}"
                                    class="block border-b border-gray-200 px-2 py-2 text-sm text-gray-700 hover:bg-gray-100 lg:px-4 lg:py-2">
                                    Search Available Appointments
                                </a>
                                <a href="{{ route('student.appointments.create') }}"
                                    class="block border-b border-gray-200 px-2 py-2 text-sm text-gray-700 hover:bg-gray-100 lg:px-4 lg:py-2">
                                    Create Appointments
                                </a>

                                @if (isset($appointment))
                                    <a href="{{ route('student.appointments.edit', $appointment->id) }}"
                                        class="block px-2 py-2 text-sm text-gray-700 hover:bg-gray-100 lg:px-4 lg:py-2">
                                        Edit Appointment
                                    </a>
                                @else
                                    <span
                                        class="block cursor-not-allowed px-2 py-1 text-sm text-gray-400 lg:px-4 lg:py-2">
                                        No appointment found to edit
                                    </span>
                                @endif
                            </div>

                            <a href="{{ route('student.links') }}"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Links
                            </a>
                            <a href="{{ route('student.profile') }}"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Profile
                            </a>
                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirmLogout();">
                                @csrf
                                <button type="submit" data-tooltip-target="tooltip-bottom"
                                    data-tooltip-placement="bottom"
                                    class="border-1.5px mr-0 rounded-[25%] border-[#7D3C98] bg-red-600 px-1 py-1 text-white hover:shadow-lg lg:px-2 lg:py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="#ffffffff" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 3H6a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h4M16 17l5-5-5-5M19.8 12H9" />
                                    </svg>
                                </button>
                                <div id="tooltip-bottom" role="tooltip"
                                    class="duration-400 z-12 tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-red-600 opacity-0 shadow-md transition-opacity">
                                    Log Out
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </form>
                        </div>
                    @elseif (Auth::user()->role === 'mentor')
                        <div class="flex items-center gap-2">
                            <a href="{{ route('mentor.dashboard') }}"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Home
                            </a>
                            <a href="{{ route('newsletter') }}"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Portal
                            </a>
                            <!-- Timetables Dropdown -->
                            <button id="dropdownButton"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white focus:outline-none lg:px-4 lg:py-2">
                                Timetables
                            </button>
                            <div id="dropdownMenu"
                                class="absolute right-[110px] top-[110px] z-10 mt-2 hidden w-48 w-fit rounded-md border border-gray-300 bg-white text-xs shadow-xl lg:right-[200px] lg:top-[130px] lg:mt-3 lg:text-sm">
                                <a href="{{ route('mentor.timetables.create') }}"
                                    class="block border-b border-gray-200 px-2 py-2 text-sm text-gray-700 hover:bg-gray-100 lg:px-4 lg:py-2">
                                    Create Timetable
                                </a>
                                <a href="{{ route('mentor.timetables.edit') }}"
                                    class="block border-b border-gray-200 px-2 py-2 text-sm text-gray-700 hover:bg-gray-100 lg:px-4 lg:py-2">
                                    Edit Timetable
                                </a>
                                <a href="{{ route('mentor.timetables.students') }}"
                                    class="block px-2 py-2 text-sm text-gray-700 hover:bg-gray-100 lg:px-4 lg:py-2">
                                    See Your Students
                                </a>
                            </div>
                            <a href="{{ route('mentor.links') }}"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Links
                            </a>
                            <a href="{{ route('mentor.profile') }}"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Profile
                            </a>
                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirmLogout();">
                                @csrf
                                <button type="submit" data-tooltip-target="tooltip-bottom"
                                    data-tooltip-placement="bottom"
                                    class="border-1.5px mr-0 rounded-[25%] border-[#7D3C98] bg-red-600 px-2 py-2 text-white hover:shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="#ffffffff" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 3H6a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h4M16 17l5-5-5-5M19.8 12H9" />
                                    </svg>
                                </button>
                                <div id="tooltip-bottom" role="tooltip"
                                    class="duration-400 z-12 tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-red-600 opacity-0 shadow-md transition-opacity">
                                    Log Out
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </form>
                        </div>
                    @elseif (Auth::user()->role === 'team_leader')
                        <div class="flex items-center gap-2">
                            <a href="{{ route('team_leader.dashboard') }}"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Home
                            </a>
                            <a href="{{ route('newsletter') }}"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Portal
                            </a>

                            <!-- Timetables Dropdown -->
                            <button id="dropdownButton"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white focus:outline-none lg:px-4 lg:py-2">
                                Timetables
                            </button>
                            <div id="dropdownMenu"
                                class="absolute right-20 top-[75px] z-10 mt-2 hidden w-48 w-fit rounded-md border border-gray-300 bg-white text-xs shadow-xl lg:right-40 lg:top-[75px] lg:text-sm">
                                <a href="{{ route('team_leader.view_timetables') }}"
                                    class="block border-b border-gray-200 px-2 py-2 text-sm text-gray-700 hover:bg-gray-100 lg:px-4 lg:py-2">
                                    Check Mentor-Student Timetables
                                </a>
                                <a href="{{ route('team_leader.timetable.create') }}"
                                    class="block border-b border-gray-200 px-2 py-2 text-sm text-gray-700 hover:bg-gray-100 lg:px-4 lg:py-2">
                                    Reserve TeamLeader Timetable
                                </a>
                                <a href="{{ route('team_leader.timetable.availability') }}"
                                    class="block px-2 py-2 text-sm text-gray-700 hover:bg-gray-100 lg:px-4 lg:py-2">
                                    TeamLeader Timetable Availability
                                </a>
                            </div>
                            <a href="{{ route('team_leader.links') }}"
                                class="nav-link block-start inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Links
                            </a>
                            <a href="{{ route('team_leader.profile') }}"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Profile
                            </a>
                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirmLogout();">
                                @csrf
                                <button type="submit" data-tooltip-target="tooltip-bottom"
                                    data-tooltip-placement="bottom"
                                    class="border-1.5px mr-0 rounded-[25%] border-[#7D3C98] bg-red-600 px-2 py-2 text-white hover:shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="#ffffffff" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 3H6a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h4M16 17l5-5-5-5M19.8 12H9" />
                                    </svg>
                                </button>
                                <div id="tooltip-bottom" role="tooltip"
                                    class="duration-400 z-12 tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-red-600 opacity-0 shadow-md transition-opacity">
                                    Log Out
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </form>
                        </div>
                    @elseif (Auth::user()->role === 'admin')
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Home
                            </a>
                            <a href="{{ route('newsletter') }}"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Portal
                            </a>
                            <!-- Management Dropdown -->

                            <button id="dropdownButton"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Manage
                            </button>
                            <div id="dropdownMenu"
                                class="absolute right-[175px] top-[75px] z-10 flex hidden w-fit flex-col rounded-md border border-gray-200 bg-white p-1 text-xs shadow-md lg:text-sm">
                                <p class="rounded-t-sm bg-blue-500 px-2 py-1.5 text-sm font-semibold text-white">
                                    Users & Timetables
                                </p>
                                <a href="{{ route('admin.mentor_students_timetable') }}"
                                    class="block px-2 py-2 text-xs text-blue-500 hover:bg-gray-100">
                                    Mentor-Students Timetable
                                </a>
                                <a href="{{ route('admin.team_leaders_timetable') }}"
                                    class="block px-2 py-2 text-xs text-blue-500 hover:bg-gray-100">
                                    TeamLeader Timetable
                                </a>

                                <a href="{{ route('admin.users.index') }}"
                                    class="block px-2 py-2 text-xs text-blue-500 hover:bg-gray-100">
                                    Delete Users
                                </a>
                                <p class="bg-yellow-400 px-2 py-1.5 text-sm font-semibold text-white">
                                    Forms
                                </p>
                                <a href="{{ route('admin.forms.index') }}"
                                    class="block px-2 py-2 text-xs text-yellow-500 hover:bg-gray-100">
                                    Manage Forms
                                </a>
                                <a href="{{ route('admin.forms.tracking') }}"
                                    class="block px-2 py-2 text-xs text-yellow-500 hover:bg-gray-100">
                                    Track Form Completion
                                </a>
                                <a href="{{ route('admin.attendance.index') }}"
                                    class="block px-2 py-2 text-xs text-yellow-500 hover:bg-gray-100">
                                    Student Attendance Reports
                                </a>
                                <p class="rounded-b-sm bg-green-600 px-2 py-1.5 text-sm font-semibold text-white">
                                    Analytics
                                </p>
                                <a href="{{ route('admin.database_analytics') }}"
                                    class="block px-2 py-2 text-xs text-green-600 hover:bg-gray-100">
                                    Database Analytics
                                </a>
                            </div>

                            <a href="{{ route('admin.profile') }}"
                                class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                {{ Auth::user()->name }}
                            </a>

                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirmLogout();">
                                @csrf
                                <button type="submit" data-tooltip-target="tooltip-bottom"
                                    data-tooltip-placement="bottom"
                                    class="border-1.5px mr-0 rounded-[25%] border-[#7D3C98] bg-red-600 px-2 py-2 text-white hover:shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="#ffffffff" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 3H6a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h4M16 17l5-5-5-5M19.8 12H9" />
                                    </svg>
                                </button>
                                <div id="tooltip-bottom" role="tooltip"
                                    class="duration-400 z-12 tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-red-600 opacity-0 shadow-md transition-opacity">
                                    Log Out
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </form>
                        </div>
                    @endif
                @elseif (Request::is('login') ||
                        Request::is('register/student') ||
                        Request::is('register/mentor') ||
                        Request::is('register/team-leader'))
                    <div>
                        <a href="{{ route('guest') }}"
                            class="nav-link inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                            Home
                        </a>
                    </div>
                @else
                    <!-- Guest Links - Hide on login page -->
                    @if (
                        !Request::is('login') &&
                            !Request::is('register/student') &&
                            !Request::is('register/mentor') &&
                            !Request::is('register/team-leader'))
                        <div class="flex items-center justify-end">
                            <a href="{{ route('login') }}"
                                class="mr-2 inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                Log In
                            </a>
                            <div class="relative">
                                <a href="#" id="registerDropdownButton"
                                    class="mr-2 inline-flex items-center rounded-md border-[1.5px] border-[#7D3C98] bg-[#7D3C98] px-2 py-1 text-white lg:px-4 lg:py-2">
                                    Register
                                </a>
                                <div id="registerDropdownMenu"
                                    class="absolute right-0 z-10 mt-2 hidden w-48 rounded-md bg-white shadow-lg">
                                    <a href="{{ route('register.student') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Student
                                    </a>
                                    <a href="{{ route('register.mentor') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Mentor
                                    </a>
                                    <a href="{{ route('register.team_leader') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Team Leader
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 pt-16">
            {{ $slot }}
        </main>
        <!-- Footer -->
        <!-- Footer -->
        @if (
            !Request::is('login') &&
                !Request::is('register/student') &&
                !Request::is('register/mentor') &&
                !Request::is('register/team-leader'))
            <footer class="bg-slate-900 text-white">

                <!-- Main Footer -->
                <div class="px-6 py-12 lg:px-24 lg:py-16">

                    <div
                        class="mx-auto grid max-w-7xl grid-cols-1 gap-10 border-b border-gray-700/70 pb-10 sm:grid-cols-2 lg:grid-cols-4 lg:gap-12">

                        <!-- Brand / About -->
                        <div class="flex flex-col gap-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 p-1.5">
                                    <img src="/images/rsuGlobal.png" alt="RSU Logo"
                                        class="h-full w-full object-contain" />
                                </div>

                                <div>
                                    <h1 class="text-lg font-bold tracking-wider text-white lg:text-2xl">
                                        RSU GLOBAL!
                                    </h1>

                                    <span class="text-xs tracking-wide text-[#B98CCB]">
                                        PAL Center
                                    </span>
                                </div>

                            </div>

                            <p class="max-w-sm text-sm leading-relaxed text-gray-400">
                                Enhancing English communication skills through
                                peer assisted learning and mentorship at Rangsit
                                University.
                            </p>

                        </div>


                        <!-- Quick Links -->
                        <div>

                            <h2 class="mb-5 text-base font-semibold tracking-wide text-white lg:text-lg">
                                Quick Links
                            </h2>

                            <ul class="space-y-3 text-sm text-gray-400">

                                <li>
                                    <a href=""
                                        class="inline-flex transition-all duration-200 hover:translate-x-1 hover:text-[#B98CCB]">
                                        About Us
                                    </a>
                                </li>

                                <li>
                                    <a href=""
                                        class="inline-flex transition-all duration-200 hover:translate-x-1 hover:text-[#B98CCB]">
                                        Mentorship Program
                                    </a>
                                </li>

                                <li>
                                    <a href=""
                                        class="inline-flex transition-all duration-200 hover:translate-x-1 hover:text-[#B98CCB]">
                                        Volunteer Opportunities
                                    </a>
                                </li>

                                <li>
                                    <a href=""
                                        class="inline-flex transition-all duration-200 hover:translate-x-1 hover:text-[#B98CCB]">
                                        Resource Portal
                                    </a>
                                </li>

                            </ul>

                        </div>


                        <!-- Programs -->
                        <div>

                            <h2 class="mb-5 text-base font-semibold tracking-wide text-white lg:text-lg">
                                Programs
                            </h2>

                            <ul class="space-y-3 text-sm text-gray-400">

                                <li>
                                    <a href=""
                                        class="inline-flex transition-all duration-200 hover:translate-x-1 hover:text-[#B98CCB]">
                                        Undergraduate Mentoring
                                    </a>
                                </li>

                                <li>
                                    <a href=""
                                        class="inline-flex transition-all duration-200 hover:translate-x-1 hover:text-[#B98CCB]">
                                        International Exchange
                                    </a>
                                </li>

                                <li>
                                    <a href=""
                                        class="inline-flex transition-all duration-200 hover:translate-x-1 hover:text-[#B98CCB]">
                                        Become a Team Leader
                                    </a>
                                </li>

                                <li>
                                    <a href=""
                                        class="inline-flex transition-all duration-200 hover:translate-x-1 hover:text-[#B98CCB]">
                                        Language Workshops
                                    </a>
                                </li>

                            </ul>

                        </div>


                        <!-- Contact Us -->
                        <div>

                            <h2 class="mb-5 text-base font-semibold tracking-wide text-white lg:text-lg">
                                Contact Us
                            </h2>

                            <ul class="space-y-3 text-sm leading-relaxed text-gray-400">

                                <li>
                                    Email: rsuip@rsu.ac.th
                                </li>

                                <li>
                                    Phone: +66 1234 5678
                                </li>

                                <li>
                                    Address: 52/347, Mueang Ek, Pathum Thani
                                    12000, Thailand
                                </li>

                            </ul>

                        </div>

                    </div>


                    <!-- Bottom Footer -->
                    <div
                        class="mx-auto flex max-w-7xl flex-col gap-3 pt-8 text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between lg:text-sm">

                        <p>
                            &copy; 2026 RSUGlobal!
                        </p>

                        <p>
                            Designed by ICT Students. All rights reserved.
                        </p>

                    </div>

                </div>

            </footer>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all dropdown buttons
            const registerButton = document.getElementById(
                'registerDropdownButton',
            );
            const registerMenu = document.getElementById(
                'registerDropdownMenu',
            );

            if (registerButton && registerMenu) {
                registerButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    registerMenu.classList.toggle('hidden');
                });

                // Close dropdown when clicking elsewhere
                document.addEventListener('click', function(event) {
                    if (
                        !registerButton.contains(event.target) &&
                        !registerMenu.contains(event.target)
                    ) {
                        registerMenu.classList.add('hidden');
                    }
                });
            }

            // Handle color changes for .nav-link based on current path
            const currentPath = window.location.pathname;
            const links = document.querySelectorAll('.nav-link');

            links.forEach((link) => {
                if (link.hasAttribute('href')) {
                    let linkPath;
                    try {
                        linkPath = new URL(
                            link.getAttribute('href'),
                            window.location.origin,
                        ).pathname;
                    } catch (e) {
                        linkPath = link.getAttribute('href');
                    }
                    if (linkPath === currentPath) {
                        link.classList.remove('bg-[#7D3C98]', 'text-white');
                        link.classList.add('bg-white', 'text-[#7D3C98]');
                    }
                }
            });

            // Highlight dropdown buttons if any of their dropdown links match current path
            const dropdownButtons =
                document.querySelectorAll('#dropdownButton');
            dropdownButtons.forEach((button) => {
                // Find the next sibling dropdownMenu
                let dropdownMenu = button.nextElementSibling;
                if (dropdownMenu && dropdownMenu.id === 'dropdownMenu') {
                    const dropdownLinks =
                        dropdownMenu.querySelectorAll('a[href]');
                    dropdownLinks.forEach((link) => {
                        let linkPath;
                        try {
                            linkPath = new URL(
                                link.getAttribute('href'),
                                window.location.origin,
                            ).pathname;
                        } catch (e) {
                            linkPath = link.getAttribute('href');
                        }
                        if (linkPath === currentPath) {
                            button.classList.remove(
                                'bg-[#7D3C98]',
                                'text-white',
                            );
                            button.classList.add(
                                'bg-white',
                                'text-[#7D3C98]',
                            );
                        }
                    });
                }
            });

            const dropdownButton =
                document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');

            if (dropdownButton && dropdownMenu) {
                dropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });

                // Close dropdown when clicking elsewhere
                document.addEventListener('click', function(event) {
                    if (
                        !dropdownButton.contains(event.target) &&
                        !dropdownMenu.contains(event.target)
                    ) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            }
        });

        function confirmLogout() {
            return confirm('Are you sure you want to log out?');
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>

</html>
