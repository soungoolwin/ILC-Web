<x-guest-layout>
    <div class="flex justify-center items-center min-h-screen">
        <div id="signup_main_Div" class="w-full max-w-lg bg-white shadow-xl rounded-lg p-8">
            <img id="logo" class="mx-auto w-24 mb-6" src="/images/rsuGlobal.png" alt="Logo">

            <form method="POST" action="{{ route('register.admin') }}" class="space-y-4">
                @csrf

                <h3 class="form-title text-center text-2xl font-bold text-gray-800 mb-6">Admin Registration</h3>

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
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        placeholder="Enter your full name" required>
                </div>

                <!-- Nickname -->
                <div>
                    <label for="nickname" class="block text-sm font-semibold text-gray-600 mb-1">Nickname</label>
                    <input type="text" id="nickname" name="nickname" value="{{ old('nickname') }}"
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
                    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        placeholder="061 ***** 02">
                </div>

                <!-- Line ID -->
                <div>
                    <label for="line_id" class="block text-sm font-semibold text-gray-600 mb-1">Line ID</label>
                    <input type="text" id="line_id" name="line_id" value="{{ old('line_id') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        placeholder="Enter your Line ID">
                </div>

                <!-- Admin ID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Student ID field renamed to match UI -->
                        <div>
                            <label for="admin_id" class="block text-gray-800 mb-2">Admin ID</label>
                            <input type="text" id="admin_id" name="admin_id" value="{{ old('admin_id') }}"
                                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                placeholder="Enter admin ID" required>
                            @error('admin_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="adm_id_confirmation" class="block text-gray-800 mb-2">Confirm ID</label>
                            <input type="text" id="adm_id_confirmation" name="adm_id_confirmation"
                                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                placeholder="Re-enter ID" required>

                            @error('adm_id_confirmation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <p id="confirmation_message" class="text-red-500 text-sm mt-1"></p>
                        </div>

                        
                    </div>

                <!-- Password
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-600 mb-1">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        placeholder="Use the one you won't forget" required>
                </div>

                <!-- Confirm Password
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-600 mb-1">Confirm
                        Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        placeholder="Re-enter your password" required>
                </div> -->

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
                        class="w-full bg-gradient-to-r text-white font-bold py-3 rounded-lg shadow-lg hover:shadow-xl bg-[#7D3C98] transition">
                        Create Account
                    </button>
                </div>

                <!-- Login Link -->
                <div class="mt-4 text-center flex items-center justify-center gap-2">
                    <p>Have an account?</p>
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
