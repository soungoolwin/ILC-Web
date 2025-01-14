<x-guest-layout>
    <div class="flex justify-center items-center min-h-screen">
        <div id="signup_main_Div" class="w-full max-w-lg bg-white shadow-xl rounded-lg p-8">
            <img id="logo" class="mx-auto w-24 mb-6" src="/images/logo_new.png" alt="Logo">
            <form method="POST" action="{{ route('register.team_leader') }}" class="space-y-4">
                @csrf

                <h3 class="form-title text-center text-2xl font-bold text-gray-800 mb-6">Team Leader Registration</h3>

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

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-600 mb-1">Full Name</label>
                    <input type="text" id="firstname" name="name" value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        placeholder="Enter your full name" required>
                </div>

                <!-- Nickname -->
                <div>
                    <label for="nickname" class="block text-sm font-semibold text-gray-600 mb-1">Nickname</label>
                    <input type="text" id="Nickname" name="nickname" value="{{ old('nickname') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        placeholder="Enter your nickname" required>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        placeholder="xyz@rsu.ac.th" required>
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone_number" class="block text-sm font-semibold text-gray-600 mb-1">Phone
                        Number</label>
                    <input type="text" id="Phone Number" name="phone_number" value="{{ old('phone_number') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        placeholder="061 ***** 02">
                </div>

                <!-- Line ID -->
                <div>
                    <label for="line_id" class="block text-sm font-semibold text-gray-600 mb-1">Line ID</label>
                    <input type="text" id="Line Id" name="line_id" value="{{ old('line_id') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        placeholder="please check carefully">
                </div>

                <!-- Team Leader ID -->
                <div>
                    <label for="team_leader_id" class="block text-sm font-semibold text-gray-600 mb-1">Team Leader
                        ID</label>
                    <input type="text" id="team_leader_id" name="team_leader_id" value="{{ old('team_leader_id') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        placeholder="Enter your Team Leader ID" required>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-600 mb-1">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        placeholder="Use the one you won't forget" required>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-600 mb-1">Confirm
                        Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        placeholder="Re-enter your password" required>
                </div>

                <!-- Terms Checkbox -->
                <div class="flex items-center">
                    <input type="checkbox" id="terms" name="terms"
                        class="w-5 h-5 text-blue-500 focus:ring-blue-400 border-gray-300 rounded" required>
                    <label for="terms" class="ml-2 text-sm text-gray-600">I agree to the Terms of Service and Privacy
                        Policy</label>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button id="signupBtn" type="submit"
                        class="w-full bg-gradient-to-r  text-white font-bold py-3 rounded-lg shadow-lg hover:shadow-xl bg-[#8E5C65] transition">
                        Create Account
                    </button>
                </div>

                <!-- Login Link -->
                <div id="loginPageDiv" class="mt-4 text-center flex items-center justify-center gap-2">
                    <p>Have an account?</p>
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
