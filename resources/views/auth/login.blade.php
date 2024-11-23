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
                        <a href="./signup.html" class="text-sm text-blue-500 hover:text-blue-700">Signup</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
