<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <div class="flex flex-col min-h-screen">

        <!-- Navigation Bar -->
        <nav class="bg-[#D8E2E6] p-4 shadow">
            <div class="container mx-auto flex justify-between items-center">
                <img id="logo" class="w-10" src="/images/logo.png" alt="Logo">
                <div class="flex items-center space-x-4 relative">
                    <!-- Dynamic Links Based on Role -->
                    @if (Auth::check())
                        @if (Auth::user()->role === 'student')
                            <a href="{{ route('student.dashboard') }}"
                                class="text-white bg-[#8b6e73] px-2 py-1 rounded-md shadow-md">Dashboard</a>
                            <a href="{{ route('student.profile') }}"
                                class="text-white bg-[#8b6e73] px-2 py-1 rounded-md shadow-md">Profile</a>
                            <!-- Appointments Dropdown -->
                            <div class="relative">
                                <button id="dropdownButton"
                                    class="text-white bg-[#8b6e73] px-2 py-1 rounded-md shadow-md focus:outline-none">Appointments</button>
                                <div id="dropdownMenu" class="absolute mt-2 w-48 bg-white rounded-md shadow-lg hidden">
                                    <a href="{{ route('student.appointments.create') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Create Appointments
                                    </a>
                                    <a href="{{ route('mentor.timetables.edit') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 ">
                                        Edit Appointments
                                    </a>

                                </div>
                            </div>
                        @elseif (Auth::user()->role === 'mentor')
                            <a href="{{ route('mentor.dashboard') }}"
                                class="text-white bg-[#8b6e73] px-2 py-1 rounded-md shadow-md">Dashboard</a>
                            <a href="{{ route('mentor.profile') }}"
                                class="text-white bg-[#8b6e73] px-2 py-1 rounded-md shadow-md">Profile</a>

                            <!-- Timetables Dropdown -->
                            <div class="relative">
                                <button id="dropdownButton"
                                    class="text-white focus:outline-none bg-[#8b6e73] px-2 py-1 rounded-md shadow-md">Timetables</button>
                                <div id="dropdownMenu" class="absolute mt-2 w-48 bg-white rounded-md shadow-lg hidden">
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
                        @elseif (Auth::user()->role === 'team_leader')
                            <a href="{{ route('team_leader.dashboard') }}"
                                class="text-white bg-[#8b6e73] px-2 py-1 rounded-md shadow-md">Dashboard</a>
                            <a href="{{ route('team_leader.profile') }}"
                                class="text-white bg-[#8b6e73] px-2 py-1 rounded-md shadow-md">Profile</a>

                            <!-- Timetables Dropdown -->
                            <div class="relative">
                                <button id="dropdownButton"
                                    class="text-white focus:outline-none bg-[#8b6e73] px-2 py-1 rounded-md shadow-md ">Timetables</button>
                                <div id="dropdownMenu" class="absolute mt-2 w-48 bg-white rounded-md shadow-lg hidden">
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
                                class="text-white bg-[#8b6e73] px-2 py-1 rounded-md shadow-md">Dashboard</a>
                            <!-- Timetables Dropdown -->
                            <div class="relative">
                                <button id="dropdownButton"
                                    class="text-white focus:outline-none bg-[#8b6e73] px-2 py-1 rounded-md shadow-md">Timetables</button>
                                <div id="dropdownMenu" class="absolute mt-2 w-48 bg-white rounded-md shadow-lg hidden">
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
                                class="text-white bg-[#8b6e73] px-2 py-1 rounded-md shadow-md">Profile</a>
                        @endif

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-white bg-[#8b6e73] px-2 py-1 rounded-md shadow-md">Logout</button>
                        </form>
                    @else
                        <!-- Guest Links -->
                        <div class="relative">
                            <button id="registerDropdownButton"
                                class="text-white focus:outline-none bg-[#8b6e73] px-2 py-1 rounded-md shadow-md">
                                Register
                            </button>
                            <div id="registerDropdownMenu"
                                class="absolute mt-2 w-48 bg-white rounded-md shadow-lg hidden">
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
                                {{-- <a href="{{ route('register.admin') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Admin
                                </a> --}}
                            </div>
                        </div>

                        <!-- Login Link -->
                        <a href="{{ route('login') }}"
                            class="text-white bg-[#8b6e73] px-2 py-1 rounded-md shadow-md">Login</a>
                    @endif
                </div>
            </div>
        </nav>

        <div class="flex flex-1">

            <!-- Side Navigation -->
            {{-- <aside class="bg-white w-64 p-4 shadow-md">
                <h2 class="font-bold text-lg">Sidebar</h2>
                <ul>
                    <li><a href="#" class="block py-2 text-gray-700 hover:bg-gray-200">Dashboard</a></li>
                    <li><a href="#" class="block py-2 text-gray-700 hover:bg-gray-200">Profile</a></li>
                    <li><a href="#" class="block py-2 text-gray-700 hover:bg-gray-200">Settings</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block py-2 text-gray-700 hover:bg-gray-200 text-left w-full">Logout</button>
                        </form>
                    </li>
                </ul>
            </aside> --}}

            <!-- Main Content -->
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>

        </div>

        <!-- Footer -->
        <footer class="bg-[#D8E2E6] text-black text-center p-4 relative">
            <p>&copy; 2025 Designed by ICT Students. All rights reserved.</p>


            <div class="absolute right-7  flex flex-row top-2">

                <!-- YouTube Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="40"
                    viewBox="0 0 48 48">
                    <path fill="#FF3D00"
                        d="M43.2,33.9c-0.4,2.1-2.1,3.7-4.2,4c-3.3,0.5-8.8,1.1-15,1.1c-6.1,0-11.6-0.6-15-1.1c-2.1-0.3-3.8-1.9-4.2-4C4.4,31.6,4,28.2,4,24c0-4.2,0.4-7.6,0.8-9.9c0.4-2.1,2.1-3.7,4.2-4C12.3,9.6,17.8,9,24,9c6.2,0,11.6,0.6,15,1.1c2.1,0.3,3.8,1.9,4.2,4c0.4,2.3,0.9,5.7,0.9,9.9C44,28.2,43.6,31.6,43.2,33.9z">
                    </path>
                    <path fill="#FFF" d="M20 31L20 17 32 24z"></path>
                </svg>
                <path fill="#00c300"
                    d="M12.5,42h23c3.59,0,6.5-2.91,6.5-6.5v-23C42,8.91,39.09,6,35.5,6h-23C8.91,6,6,8.91,6,12.5v23C6,39.09,8.91,42,12.5,42z">
                </path>
                <path fill="#fff"
                    d="M37.113,22.417c0-5.865-5.88-10.637-13.107-10.637s-13.108,4.772-13.108,10.637c0,5.258,4.663,9.662,10.962,10.495c0.427,0.092,1.008,0.282,1.155,0.646c0.132,0.331,0.086,0.85,0.042,1.185c0,0-0.153,0.925-0.187,1.122c-0.057,0.331-0.263,1.296,1.135,0.707c1.399-0.589,7.548-4.445,10.298-7.611h-0.001C36.203,26.879,37.113,24.764,37.113,22.417z M18.875,25.907h-2.604c-0.379,0-0.687-0.308-0.687-0.688V20.01c0-0.379,0.308-0.687,0.687-0.687c0.379,0,0.687,0.308,0.687,0.687v4.521h1.917c0.379,0,0.687,0.308,0.687,0.687C19.562,25.598,19.254,25.907,18.875,25.907z M21.568,25.219c0,0.379-0.308,0.688-0.687,0.688s-0.687-0.308-0.687-0.688V20.01c0-0.379,0.308-0.687,0.687-0.687s0.687,0.308,0.687,0.687V25.219z M27.838,25.219c0,0.297-0.188,0.559-0.47,0.652c-0.071,0.024-0.145,0.036-0.218,0.036c-0.215,0-0.42-0.103-0.549-0.275l-2.669-3.635v3.222c0,0.379-0.308,0.688-0.688,0.688c-0.379,0-0.688-0.308-0.688-0.688V20.01c0-0.296,0.189-0.558,0.47-0.652c0.071-0.024,0.144-0.035,0.218-0.035c0.214,0,0.42,0.103,0.549,0.275l2.67,3.635V20.01c0-0.379,0.309-0.687,0.688-0.687c0.379,0,0.687,0.308,0.687,0.687V25.219z M32.052,21.927c0.379,0,0.688,0.308,0.688,0.688c0,0.379-0.308,0.687-0.688,0.687h-1.917v1.23h1.917c0.379,0,0.688,0.308,0.688,0.687c0,0.379-0.309,0.688-0.688,0.688h-2.604c-0.378,0-0.687-0.308-0.687-0.688v-2.603c0-0.001,0-0.001,0-0.001c0,0,0-0.001,0-0.001v-2.601c0-0.001,0-0.001,0-0.002c0-0.379,0.308-0.687,0.687-0.687h2.604c0.379,0,0.688,0.308,0.688,0.687s-0.308,0.687-0.688,0.687h-1.917v1.23H32.052z">
                </path>
                </svg>
                <path fill="#00c300"
                    d="M12.5,42h23c3.59,0,6.5-2.91,6.5-6.5v-23C42,8.91,39.09,6,35.5,6h-23C8.91,6,6,8.91,6,12.5v23C6,39.09,8.91,42,12.5,42z">
                </path>
                <path fill="#fff"
                    d="M37.113,22.417c0-5.865-5.88-10.637-13.107-10.637s-13.108,4.772-13.108,10.637c0,5.258,4.663,9.662,10.962,10.495c0.427,0.092,1.008,0.282,1.155,0.646c0.132,0.331,0.086,0.85,0.042,1.185c0,0-0.153,0.925-0.187,1.122c-0.057,0.331-0.263,1.296,1.135,0.707c1.399-0.589,7.548-4.445,10.298-7.611h-0.001C36.203,26.879,37.113,24.764,37.113,22.417z M18.875,25.907h-2.604c-0.379,0-0.687-0.308-0.687-0.688V20.01c0-0.379,0.308-0.687,0.687-0.687c0.379,0,0.687,0.308,0.687,0.687v4.521h1.917c0.379,0,0.687,0.308,0.687,0.687C19.562,25.598,19.254,25.907,18.875,25.907z M21.568,25.219c0,0.379-0.308,0.688-0.687,0.688s-0.687-0.308-0.687-0.688V20.01c0-0.379,0.308-0.687,0.687-0.687s0.687,0.308,0.687,0.687V25.219z M27.838,25.219c0,0.297-0.188,0.559-0.47,0.652c-0.071,0.024-0.145,0.036-0.218,0.036c-0.215,0-0.42-0.103-0.549-0.275l-2.669-3.635v3.222c0,0.379-0.308,0.688-0.688,0.688c-0.379,0-0.688-0.308-0.688-0.688V20.01c0-0.296,0.189-0.558,0.47-0.652c0.071-0.024,0.144-0.035,0.218-0.035c0.214,0,0.42,0.103,0.549,0.275l2.67,3.635V20.01c0-0.379,0.309-0.687,0.688-0.687c0.379,0,0.687,0.308,0.687,0.687V25.219z M32.052,21.927c0.379,0,0.688,0.308,0.688,0.688c0,0.379-0.308,0.687-0.688,0.687h-1.917v1.23h1.917c0.379,0,0.688,0.308,0.688,0.687c0,0.379-0.309,0.688-0.688,0.688h-2.604c-0.378,0-0.687-0.308-0.687-0.688v-2.603c0-0.001,0-0.001,0-0.001c0,0,0-0.001,0-0.001v-2.601c0-0.001,0-0.001,0-0.002c0-0.379,0.308-0.687,0.687-0.687h2.604c0.379,0,0.688,0.308,0.688,0.687s-0.308,0.687-0.688,0.687h-1.917v1.23H32.052z">
                </path>
                </svg>

                <!-- Line Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="40"
                    viewBox="0 0 48 48">
                    <path fill="#00c300"
                        d="M12.5,42h23c3.59,0,6.5-2.91,6.5-6.5v-23C42,8.91,39.09,6,35.5,6h-23C8.91,6,6,8.91,6,12.5v23C6,39.09,8.91,42,12.5,42z">
                    </path>
                    <path fill="#fff"
                        d="M37.113,22.417c0-5.865-5.88-10.637-13.107-10.637s-13.108,4.772-13.108,10.637c0,5.258,4.663,9.662,10.962,10.495c0.427,0.092,1.008,0.282,1.155,0.646c0.132,0.331,0.086,0.85,0.042,1.185c0,0-0.153,0.925-0.187,1.122c-0.057,0.331-0.263,1.296,1.135,0.707c1.399-0.589,7.548-4.445,10.298-7.611h-0.001C36.203,26.879,37.113,24.764,37.113,22.417z M18.875,25.907h-2.604c-0.379,0-0.687-0.308-0.687-0.688V20.01c0-0.379,0.308-0.687,0.687-0.687c0.379,0,0.687,0.308,0.687,0.687v4.521h1.917c0.379,0,0.687,0.308,0.687,0.687C19.562,25.598,19.254,25.907,18.875,25.907z M21.568,25.219c0,0.379-0.308,0.688-0.687,0.688s-0.687-0.308-0.687-0.688V20.01c0-0.379,0.308-0.687,0.687-0.687s0.687,0.308,0.687,0.687V25.219z M27.838,25.219c0,0.297-0.188,0.559-0.47,0.652c-0.071,0.024-0.145,0.036-0.218,0.036c-0.215,0-0.42-0.103-0.549-0.275l-2.669-3.635v3.222c0,0.379-0.308,0.688-0.688,0.688c-0.379,0-0.688-0.308-0.688-0.688V20.01c0-0.296,0.189-0.558,0.47-0.652c0.071-0.024,0.144-0.035,0.218-0.035c0.214,0,0.42,0.103,0.549,0.275l2.67,3.635V20.01c0-0.379,0.309-0.687,0.688-0.687c0.379,0,0.687,0.308,0.687,0.687V25.219z M32.052,21.927c0.379,0,0.688,0.308,0.688,0.688c0,0.379-0.308,0.687-0.688,0.687h-1.917v1.23h1.917c0.379,0,0.688,0.308,0.688,0.687c0,0.379-0.309,0.688-0.688,0.688h-2.604c-0.378,0-0.687-0.308-0.687-0.688v-2.603c0-0.001,0-0.001,0-0.001c0,0,0-0.001,0-0.001v-2.601c0-0.001,0-0.001,0-0.002c0-0.379,0.308-0.687,0.687-0.687h2.604c0.379,0,0.688,0.308,0.688,0.687s-0.308,0.687-0.688,0.687h-1.917v1.23H32.052z">
                    </path>
                </svg>
            </div>
        </footer>

    </div>
</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });

        // Close the dropdown if clicked outside
        document.addEventListener('click', (event) => {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const dropdownButton = document.getElementById('registerDropdownButton');
        const dropdownMenu = document.getElementById('registerDropdownMenu');

        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
