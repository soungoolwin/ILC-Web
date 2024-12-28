<x-guest-layout>
    <div class="flex items-center justify-center">
        <div id="container" class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">
            <div id="signup_main_Div" class="w-full">
                <img id="logo" class="mx-auto my-4 w-24 mb-6" src="{{ Vite::asset('resources/images/logo.png') }}"
                    alt="RSU Logo" />
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Login</h1>

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-800 p-4 rounded-md mb-6">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                            placeholder="xyz@rsu.ac.th" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-600 mb-1">Password</label>
                        <input type="password" name="password"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                            placeholder="12345" required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full bg-[#8E5C65] text-white font-bold py-3 rounded-lg shadow-lg hover:shadow-xl transition">Login</button>
                    </div>

                    <!-- No Account Link -->
                    <div id="loginPageDiv" class="flex justify-center gap-2 mt-4">
                        <p class="text-sm">Don't have an Account?</p>
                        <div class="relative inline-block text-left">
                            <!-- Dropdown button with no border -->
                            <button
                                class="inline-flex items-center justify-center text-sm font-medium text-blue-500 hover:text-blue-700 focus:outline-none"
                                onclick="document.getElementById('signupDropdown').classList.toggle('hidden')">
                                Signup
                                <!-- Optional chevron icon -->
                                <svg class="ml-2 h-5 w-5 text-blue-500 hover:text-blue-700"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.62l3.71-3.39a.75.75 0 111.04 1.08l-4.24 3.88a.75.75 0 01-1.04 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div id="signupDropdown"
                                class="absolute right-0 z-10 mt-2 hidden w-44 origin-top-right rounded-md bg-white shadow-lg">
                                <a href="/register/student"
                                    class="block px-4 py-2 text-sm text-blue-500 hover:text-blue-700">
                                    Student
                                </a>
                                <a href="/register/mentor"
                                    class="block px-4 py-2 text-sm text-blue-500 hover:text-blue-700">
                                    Mentor
                                </a>
                                <a href="register/team-leader"
                                    class="block px-4 py-2 text-sm text-blue-500 hover:text-blue-700">
                                    Teamleader
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
