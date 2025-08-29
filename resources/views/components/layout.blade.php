<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 final-scale=1.0 user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rangsit University PAL Center</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-white">
    <div class="flex flex-col min-h-screen">
        <!-- Header with Logo and Title -->
        <header class="border-b border-gray-200">
            <div class="flex items-center justify-between px-4 py-3">
                <!-- Title and Logos -->
                <div class="flex items-center justify-center w-full">
                    <img src="/images/logo_new.png" alt="RSU Logo" class=" w-14 h-14 md:w-16 md:h-16">
                    <h1 class=" font-normal text-[#7D3C98] mx-auto text-xl lg:text-3xl md:text-2xl">RSU GLOBAL!</h1>
                    <img src="/images/logo_new.png" alt="RSU Logo" class=" w-14 h-14 md:w-16 md:h-16">
                </div>
            </div>

            <!-- Navigation Bar with Login/Register -->
            <div class="flex text-xs bg-purple-100 justify-end px-1 py-1 lg:px-4 lg:py-2 border-t border-purple-200 shadow-sm md:text-sm lg:text-base">
                @if (Auth::check())
                    @if (Auth::user()->role === 'student')
                    @php
                        $appointment = null;
                        $student = Auth::user()->students()->first();
                        if ($student) {
                            $appointment = \App\Models\Appointment::where('student_id', $student->id)->latest()->first();
                        }
                    @endphp
                        <a href="{{ route('student.dashboard') }}"
                            class="inline-flex items-center text-white bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md mr-2">Dashboard</a>
                        <a href="{{ route('student.profile') }}"
                            class="inline-flex items-center text-white bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md mr-2">Profile</a>
                        <!-- Appointments Dropdown -->
                            <button id="dropdownButton"
                                class="inline-flex items-center text-white bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md focus:outline-none mr-2 ">Appointments</button>
                            <div id="dropdownMenu" class="text-xs lg:text-sm w-fit absolute top-[120px] right-[120px] lg:top-[140px] mt-2 lg:mt-3 w-48 bg-white rounded-md shadow-lg hidden z-10">
                                <a href="{{ route('student.appointments.availability') }}"
                                    class="block px-2 py-2 lg:px-4 lg:py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                    Search Available Appointments
                                </a>
                                <a href="{{ route('student.appointments.create') }}"
                                    class="block px-2 py-2 lg:px-4 lg:py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                    Create Appointments
                                </a>
                                @if (isset($appointment))
                                    <a href="{{ route('student.appointments.edit', $appointment->id) }}"
                                        class="block px-2 py-2 lg:px-4 lg:py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Edit Appointment
                                    </a>
                                @else
                                    <span class="block px-2 py-1 lg:px-4 lg:py-2 text-sm text-gray-400 cursor-not-allowed">
                                        No appointment found to edit
                                    </span>
                                @endif
                                
                            </div>

                        <a href="{{ route('student.links') }}"
                            class="inline-flex items-center text-white bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md mr-2">Links</a>
                    
                    @elseif (Auth::user()->role === 'mentor')
                        <a href="{{ route('mentor.dashboard') }}"
                            class="inline-flex items-center text-white bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md mr-2">Dashboard</a>
                        <a href="{{ route('mentor.profile') }}"
                            class="inline-flex items-center text-white bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md mr-2">Profile</a>
                @if (Auth::user()->role === 'mentor' && Auth::user()->mentors()->first()->status == 'active')

                        <!-- Timetables Dropdown -->
                            <button id="dropdownButton"
                                class="inline-flex items-center text-white bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md focus:outline-none mr-2 ">Timetables</button>
                            <div id="dropdownMenu" class="text-xs lg:text-sm w-fit absolute top-[120px] right-[120px] mt-2 lg:mt-3 w-48 bg-white rounded-md shadow-lg hidden z-10">
                                <a href="{{ route('mentor.timetables.create') }}"
                                    class="block px-2 py-2 lg:px-4 lg:py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                    Create Timetable
                                </a>
                                <a href="{{ route('mentor.timetables.edit') }}"
                                    class="block px-2 py-2 lg:px-4 lg:py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                    Edit Timetable
                                </a>
                                <a href="{{ route('mentor.timetables.students') }}"
                                    class="block px-2 py-2 lg:px-4 lg:py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    See Your Students
                                </a>
                            </div>
                        <a href="{{ route('mentor.links') }}"
                            class="inline-flex items-center text-white bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md mr-2">Links</a> 

                    @endif
                    @elseif (Auth::user()->role === 'team_leader')
                        <a href="{{ route('team_leader.dashboard') }}"
                            class="inline-flex items-center text-white bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md mr-2">Dashboard</a>
                        <a href="{{ route('team_leader.profile') }}"
                            class="inline-flex items-center text-white bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md mr-2">Profile</a>

                        <!-- Timetables Dropdown -->
                            <button id="dropdownButton"
                                class="inline-flex items-center text-white bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md focus:outline-none mr-2">Timetables</button>
                            <div id="dropdownMenu" class="text-xs lg:text-sm w-fit absolute top-[130px] right-20 lg:right-40 mt-2 w-48 bg-white rounded-md shadow-lg hidden z-10">
                                <a href="{{ route('team_leader.view_timetables') }}"
                                    class="block px-2 py-2 lg:px-4 lg:py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                    Check Mentor-Student Timetables
                                </a>
                                <a href="{{ route('team_leader.timetable.create') }}"
                                    class="block px-2 py-2 lg:px-4 lg:py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                    Reserve TeamLeader Timetable
                                </a>
                                <a href="{{ route('team_leader.timetable.availability') }}"
                                    class="block px-2 py-2 lg:px-4 lg:py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    TeamLeader Timetable Availability
                                </a>
                            </div>
                        <a href="{{ route('team_leader.links') }}"
                            class="inline-flex items-center text-white block-start bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md mr-2">Links</a>


                    @elseif (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center text-white bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md mr-2">Dashboard</a>
                        
                        <!-- Management Dropdown -->
                        
                            <button id="dropdownButton"
                                class="text-white bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md mr-2 ">Manage</button>
                            <div id="dropdownMenu" class="flex text-xs lg:text-sm w-fit absolute top-[120px] right-[80px] mt-2 lg:mt-5 w-48 bg-white rounded-md shadow-md hidden z-10 border border-gray-200">
                                <div class="flex flex-col w-fit border-r border-gray-200">
                                        <p class="px-2 py-2 lg:px-4 lg:py-2 text-sm text-white font-semibold bg-blue-500">Users & Timetables</p>
                                        <a href="{{ route('admin.mentor_students_timetable') }}"
                                            class="block px-2 py-2 lg:px-4 lg:py-2 text-xs text-blue-500 hover:bg-gray-100">
                                            Mentor-Students Timetable
                                        </a>
                                        <a href="{{ route('admin.team_leaders_timetable') }}"
                                            class="block px-2 py-2 lg:px-4 lg:py-2 text-xs text-blue-500 hover:bg-gray-100">
                                            TeamLeader Timetable
                                        </a>

                                        <a href="{{ route('dashboard.team_leaders') }}"
                                            class="block px-2 py-2 lg:px-4 lg:py-2 text-xs text-blue-500 hover:bg-gray-100">
                                            Delete Teamleaders
                                        </a>
                                        <a href="{{ route('dashboard.users') }}"
                                            class="block px-2 py-2 lg:px-4 lg:py-2 text-xs text-blue-500 hover:bg-gray-100">
                                            Delete Users
                                        </a>
                                </div>
                                <div class="flex flex-col w-fit">
                                        <p class="px-2 py-2 lg:px-4 lg:py-2 text-sm text-white font-semibold bg-yellow-400 ">Forms</p>
                                        <a href="{{ route('admin.forms.index') }}"
                                            class="block px-2 py-2 lg:px-4 lg:py-2 text-xs text-yellow-500 hover:bg-gray-100">
                                            Manage Forms
                                        </a>
                                        <a href="{{ route('admin.forms.tracking') }}"
                                            class="block px-2 py-2 lg:px-4 lg:py-2 text-xs text-yellow-500 hover:bg-gray-100">
                                            Track Form Completion
                                        </a>
                                </div>
                            </div>
                        
                        <a href="{{ route('admin.profile') }}"
                            class="inline-flex items-center text-white bg-[#7D3C98] px-2 py-1 lg:px-4 lg:py-2 rounded-md mr-2">
                            {{ Auth::user()->name }}
                        </a>
                    @endif

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline" onsubmit="return confirmLogout()">
                        @csrf
                        <button type="submit" data-tooltip-target="tooltip-bottom" data-tooltip-placement="bottom" 
                            class="text-white mr-1 bg-red-600 px-1 py-1 lg:px-2 lg:py-2 rounded-3xl hover:shadow-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10 3H6a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h4M16 17l5-5-5-5M19.8 12H9"/></svg></button>
                            <div id="tooltip-bottom" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-red-600 bg-gray-100 rounded-lg shadow-xs opacity-0 transition-opacity duration-400 tooltip">
                            Log Out
                            <div class="tooltip-arrow" data-popper-arrow></div>
</div>
                    </form>
                @else
                    <!-- Guest Links - Hide on login page -->
                    @if (!Request::is('login') && !Request::is('register/student') && !Request::is('register/mentor') && !Request::is('register/team-leader'))
                        <div class="flex justify-center items-center">
                            <a href="{{ route('login') }}"
                                class="text-white bg-[#7D3C98] px-4 py-2 rounded-md mr-2">Log In</a>
                            <div class="relative">
                                <a href="#" id="registerDropdownButton"
                                    class="text-white bg-[#7D3C98] px-4 py-[10.5px] rounded-md ">Register</a>
                                <div id="registerDropdownMenu"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden z-10">
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
        <main class="flex-1">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-[#7D3C98] text-xs lg:text-base text-center text-white p-4">
            <p>&copy; 2025 Designed by ICT Students. All rights reserved.</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all dropdown buttons
            const registerButton = document.getElementById('registerDropdownButton');
            const registerMenu = document.getElementById('registerDropdownMenu');

            if (registerButton && registerMenu) {
                registerButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    registerMenu.classList.toggle('hidden');
                });

                // Close dropdown when clicking elsewhere
                document.addEventListener('click', function(event) {
                    if(!registerButton.contains(event.target) && !registerMenu.contains(event.target)) {
                        registerMenu.classList.add('hidden');
                    }
                });
            }

            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');

            if (dropdownButton && dropdownMenu) {
                dropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });

                // Close dropdown when clicking elsewhere
                document.addEventListener('click', function(event) {
                    if(!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
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
