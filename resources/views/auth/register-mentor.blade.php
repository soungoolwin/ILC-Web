<x-guest-layout>
    <div class="bg-gradient-to-r from-blue-100 flex items-center justify-center">
        <div class="w-full max-w-lg bg-white shadow-xl rounded-2xl p-8">
            <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Mentor Registration</h2>
            <form method="POST" action="{{ route('register.mentor') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-600 mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        required>
                </div>
                <div>
                    <label for="nickname" class="block text-sm font-semibold text-gray-600 mb-1">Nickname</label>
                    <input type="text" name="nickname" value="{{ old('nickname') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-600 mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        required>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-600 mb-1">Confirm
                        Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        required>
                </div>
                <div>
                    <label for="line_id" class="block text-sm font-semibold text-gray-600 mb-1">Line ID</label>
                    <input type="text" name="line_id" value="{{ old('line_id') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                </div>
                <div>
                    <label for="phone_number" class="block text-sm font-semibold text-gray-600 mb-1">Phone
                        Number</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                </div>
                <div>
                    <label for="mentor_id" class="block text-sm font-semibold text-gray-600 mb-1">Mentor ID</label>
                    <input type="text" name="mentor_id" value="{{ old('mentor_id') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        required>
                </div>
                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold py-3 rounded-lg shadow-lg hover:shadow-xl hover:from-blue-600 hover:to-purple-700 transition">Sign
                        Up</button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
