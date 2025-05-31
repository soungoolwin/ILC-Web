<x-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-white px-4 py-10">
        <!-- Main Content Container -->
        <div class="w-full max-w-3xl">
            <!-- Title -->
            <h1 class="text-2xl font-bold text-center text-gray-900 mb-8">Create Team Leader Account</h1>

            <!-- Form Card with Light Border -->
            <div class="w-full bg-white border border-[#7D3C98] rounded-lg p-6 md:p-8">
                <form method="POST" action="{{ route('register.team_leader') }}" id="team-leader-form" class="space-y-6">
                    @csrf

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-800 p-4 rounded-md mb-6">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Two Column Layout for Name and Nickname -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-gray-800 mb-2">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="w-full border border-[#9B59B6] rounded-md px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none"
                                placeholder="Enter name" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nickname -->
                        <div>
                            <label for="nickname" class="block text-gray-800 mb-2">Nickname</label>
                            <input type="text" id="nickname" name="nickname" value="{{ old('nickname') }}"
                                class="w-full border border-[#9B59B6] rounded-md px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none"
                                placeholder="Enter nickname" required>
                            @error('nickname')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone Number - Full Width (Note: Order changed to match screenshot) -->
                    <div>
                        <label for="phone_number" class="block text-gray-800 mb-2">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                            class="w-full border border-[#9B59B6] rounded-md px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none"
                            placeholder="Enter phone number">
                        @error('phone_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address - Full Width -->
                    <div>
                        <label for="email" class="block text-gray-800 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full border border-[#9B59B6] rounded-md px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none"
                            placeholder="xyz@rsu.ac.th" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Two Column Layout for Password and Confirm Password -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-gray-800 mb-2">Password</label>
                            <input type="password" id="password" name="password"
                                class="w-full border border-[#9B59B6] rounded-md px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none"
                                placeholder="Enter password" required>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-gray-800 mb-2">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full border border-[#9B59B6] rounded-md px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none"
                                placeholder="Re-enter password" required>
                            @error('password_confirmation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Line ID - Full Width -->
                    <div>
                        <label for="line_id" class="block text-gray-800 mb-2">Line ID</label>
                        <input type="text" id="line_id" name="line_id" value="{{ old('line_id') }}"
                            class="w-full border border-[#9B59B6] rounded-md px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none"
                            placeholder="Enter LINE ID">
                        @error('line_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Two Column Layout for Student ID and Faculty -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Student ID field (previously team_leader_id) -->
                        <div>
                            <label for="team_leader_id" class="block text-gray-800 mb-2">Student ID</label>
                            <input type="text" id="team_leader_id" name="team_leader_id" value="{{ old('team_leader_id') }}"
                                class="w-full border border-[#9B59B6] rounded-md px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none"
                                placeholder="Enter student ID" required>
                            @error('team_leader_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Faculty Field (New) -->
                        <div>
                            <label for="faculty" class="block text-gray-800 mb-2">Faculty</label>
                            <input type="text" id="faculty" name="faculty" value="{{ old('faculty') }}"
                                class="w-full border border-[#9B59B6] rounded-md px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none"
                                placeholder="Enter faculty">
                            @error('faculty')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Two Column Layout for Language and Level -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Language Field (New) -->
                        <div>
                            <label for="language" class="block text-gray-800 mb-2">Language</label>
                            <input type="text" id="language" name="language" value="{{ old('language') }}"
                                class="w-full border border-[#9B59B6] rounded-md px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none"
                                placeholder="Enter language">
                            @error('language')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Level Field (New) -->
                        <div>
                            <label for="level" class="block text-gray-800 mb-2">Level</label>
                            <input type="text" id="level" name="level" value="{{ old('level') }}"
                                class="w-full border border-[#9B59B6] rounded-md px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none"
                                placeholder="Enter level">
                            @error('level')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Terms Checkbox Outside Form Card but inside form -->
                    <div class="flex items-center justify-center mt-6">
                        <input type="checkbox" id="terms" name="terms"
                            class="w-5 h-5 text-purple-500 border-[#9B59B6] rounded focus:ring-purple-400" required>
                        <label for="terms" class="ml-2 text-gray-700">I agree to the terms and policy.</label>
                    </div>

                    <!-- Submit Button - Centered -->
                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="bg-[#7D3C98] text-white font-medium py-3 px-8 rounded-md hover:bg-[#815494] transition">
                            Create Account
                        </button>
                    </div>
                </form>
            </div>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-700">
                    Already have an account? <a href="{{ route('login') }}" class="text-[#7D3C98] hover:text-[#815494]">Log in</a>
                </p>
            </div>
        </div>


    </div>
</x-layout>

<!-- Add mobile responsive styles -->
<style>
    @media (max-width: 640px) {
        input, button {
            font-size: 16px; /* Prevents zoom on mobile */
        }

        form {
            width: 100%;
        }

        .fixed.bottom-0 {
            position: relative;
            margin-top: 2rem;
        }
    }
</style>
