<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <h1 class=" font-bold text-black mx-auto text-xl md:text-2xl">RSU PAL Center</h1>
                    <img src="/images/logo_new.png" alt="RSU Logo" class=" w-14 h-14 md:w-16 md:h-16">
                </div>
            </div>

            <!-- Navigation Bar with Login/Register -->
            <div class="flex justify-end px-4 py-2 border-t border-gray-200">
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
                            class="text-white bg-[#7D3C98] px-3 py-2 rounded-md mr-2">Dashboard</a>
                        <a href="{{ route('student.profile') }}"
                            class="text-white bg-[#7D3C98] px-3 py-2 rounded-md mr-2">Profile</a>
                        <!-- Appointments Dropdown -->
                        <div class="relative mr-2">
                            <button id="dropdownButton"
                                class="text-white bg-[#7D3C98] px-3 py-2 rounded-md focus:outline-none">Appointments</button>
                            <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden z-10">
                                <a href="{{ route('student.appointments.availability') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Search Available Appointments
                                </a>
                                <a href="{{ route('student.appointments.create') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Create Appointments
                                </a>
                                @if (isset($appointment))
                                    <a href="{{ route('student.appointments.edit', $appointment->id) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Edit Appointment
                                    </a>
                                @else
                                    <span class="block px-4 py-2 text-sm text-gray-400 cursor-not-allowed">
                                        No appointment found to edit
                                    </span>
                                @endif
                                
                            </div>
                        </div>
                    @elseif (Auth::user()->role === 'mentor')
                        <a href="{{ route('mentor.dashboard') }}"
                            class="text-white bg-[#7D3C98] px-3 py-2 rounded-md mr-2">Dashboard</a>
                        <a href="{{ route('mentor.profile') }}"
                            class="text-white bg-[#7D3C98] px-3 py-2 rounded-md mr-2">Profile</a>
                @if (Auth::user()->role === 'mentor' && Auth::user()->mentors()->first()->status == 'active')

                        <!-- Timetables Dropdown -->
                        <div class="relative mr-2">
                            <button id="dropdownButton"
                                class="text-white bg-[#7D3C98] px-3 py-2 rounded-md focus:outline-none">Timetables</button>
                            <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden z-10">
                                <a href="{{ route('mentor.timetables.create') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Create Timetable
                                </a>
                                <a href="{{ route('mentor.timetables.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Edit Timetable
                                </a>
                                <a href="{{ route('mentor.timetables.students') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    See Your Students
                                </a>
                            </div>
                        </div>
                    @endif
                    @elseif (Auth::user()->role === 'team_leader')
                        <a href="{{ route('team_leader.dashboard') }}"
                            class="text-white bg-[#7D3C98] px-3 py-2 rounded-md mr-2">Dashboard</a>
                        <a href="{{ route('team_leader.profile') }}"
                            class="text-white bg-[#7D3C98] px-3 py-2 rounded-md mr-2">Profile</a>

                        <!-- Timetables Dropdown -->
                        <div class="relative mr-2">
                            <button id="dropdownButton"
                                class="text-white bg-[#7D3C98] px-3 py-2 rounded-md focus:outline-none">Timetables</button>
                            <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden z-10">
                                <a href="{{ route('team_leader.view_timetables') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Mentor-Students Timetable
                                </a>
                                <a href="{{ route('team_leader.timetable.create') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    TeamLeader Timetable
                                </a>
                                <a href="{{ route('team_leader.timetable.availability') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    TeamLeader Timetable Availability
                                </a>
                            </div>
                        </div>
                    @elseif (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-white bg-[#7D3C98] px-3 py-2 rounded-md mr-2">Dashboard</a>
                        <!-- Timetables Dropdown -->
                        <div class="relative mr-2">
                            <button id="dropdownButton"
                                class="text-white bg-[#7D3C98] px-3 py-2 rounded-md focus:outline-none">Timetables</button>
                            <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden z-10">
                                <a href="{{ route('admin.mentor_students_timetable') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Mentor-Students Timetable
                                </a>
                                <a href="{{ route('admin.team_leaders_timetable') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    TeamLeader Timetable
                                </a>

                                <a href="{{ route('dashboard.team_leaders') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Delete Teamleaders
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('admin.profile') }}"
                            class="text-white bg-[#7D3C98] px-3 py-2 rounded-md mr-2">Profile</a>
                    @endif

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="text-white bg-[#7D3C98] px-3 py-2 rounded-md">Logout</button>
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
        <footer class="bg-[#7D3C98] text-center text-white p-4">
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
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>

</html>
