<x-layout>
    <div class="flex flex-col items-center justify-center min-h-[70vh] bg-white px-4 my-8">
        <!-- Main Content Container - Centered with max width -->
        <div class="w-full max-w-md">
            <!-- Title -->
            <h1 class="text-2xl font-bold text-center text-gray-900 mb-12">Login to your account</h1>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

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
                <div class="space-y-2">
                    <label for="email" class="block text-base font-normal text-gray-800">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-[#b085c2] focus:outline-none"
                        placeholder="xyz@rsu.ac.th" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="block text-base font-normal text-gray-800">Password</label>
                    <input type="password" name="password"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-[#b085c2] focus:outline-none"
                        required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit"
                        class="w-full bg-[#7D3C98] text-white font-medium py-3 rounded-md hover:bg-[#701b94] transition">Log In</button>
                </div>

                <!-- No Account Link with Dropdown -->
                <div class="flex justify-center items-center gap-2 mt-6">
                    <p class="text-gray-800">Don't have an account?</p>
                    <div class="relative inline-block text-left">
                        <!-- Dropdown button -->
                        <button type="button"
                            class="inline-flex items-center justify-center text-[#7c369a] hover:text-[#755882] focus:outline-none relative"
                            onclick="document.getElementById('signupDropdown').classList.toggle('hidden')">
                            Sign Up
                        </button>

                        <!-- Dropdown menu -->
                        <div id="signupDropdown"
                            class="absolute z-10 mt-2 hidden w-44 origin-top-right bottom-7 rounded-md bg-white shadow-lg -right-10">
                            <a href="/register/student"
                                class="block px-4 py-2 text-sm text-purple-500 hover:text-purple-700 hover:bg-gray-50">
                                Student
                            </a>
                            <a href="/register/mentor"
                                class="block px-4 py-2 text-sm text-purple-500 hover:text-purple-700 hover:bg-gray-50">
                                Mentor
                            </a>
                            <a href="/register/team-leader"
                                class="block px-4 py-2 text-sm text-purple-500 hover:text-purple-700 hover:bg-gray-50">
                                Teamleader
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Script to close dropdown when clicking outside -->
    <script>
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('signupDropdown');
            const button = event.target.closest('button');

            if (!button && !dropdown.contains(event.target) && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</x-layout>
