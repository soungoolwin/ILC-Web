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
        <nav class="bg-[#8E5C65] p-4 shadow">
            <div class="container mx-auto flex justify-between items-center">
                <img id="logo" class="w-10" src="{{ Vite::asset('resources/images/logo.png') }}" alt="Logo">
                <div class="flex items-center space-x-4 relative">
                    <!-- Dynamic Links Based on Role -->
                    @if (Auth::check())
                        @if (Auth::user()->role === 'student')
                            <a href="{{ route('student.dashboard') }}" class="text-white">Dashboard</a>
                        @elseif (Auth::user()->role === 'mentor')
                            <a href="{{ route('mentor.dashboard') }}" class="text-white">Dashboard</a>

                            <!-- Timetables Dropdown -->
                            <div class="relative">
                                <button id="dropdownButton" class="text-white focus:outline-none">Timetables</button>
                                <div id="dropdownMenu" class="absolute mt-2 w-48 bg-white rounded-md shadow-lg hidden">
                                    <a href="{{ route('mentor.timetables.create') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Create Timetable
                                    </a>
                                    <a href="{{ route('mentor.timetables.edit') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Edit Timetable
                                    </a>
                                </div>
                            </div>
                        @elseif (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-white">Dashboard</a>
                        @endif

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-white">Logout</button>
                        </form>
                    @else
                        <!-- Guest Links -->
                        <a href="{{ route('login') }}" class="text-white">Login</a>
                        <a href="{{ route('register.student') }}" class="text-white">Register</a>
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
        <footer class="bg-[#8E5C65] text-white text-center p-4">
            <p>&copy; 2024 My Website. All rights reserved.</p>
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
</script>
