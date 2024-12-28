<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6 w-1/2">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Profile Information</h2>
            <!-- Edit Button -->
            <button id="edit-button" class="text-blue-600 hover:text-blue-800">
                Edit
            </button>
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Message -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded-md mb-6">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profile Info -->
        <div id="profile-info" class="mt-6 space-y-4 w-1/2">
            <!-- Student Table Info -->
            <div>
                <label class="text-sm font-medium text-gray-500">Student ID:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $student->student_id }}</p>
            </div>

            <!-- User Table Info -->
            <div>
                <label class="text-sm font-medium text-gray-500">Name:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $user->name }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Nickname:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $user->nickname }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Email:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $user->email }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Line ID:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $user->line_id }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Phone Number:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $user->phone_number }}</p>
            </div>
        </div>

        <!-- Edit Form (Hidden by Default) -->
        <form id="edit-form" method="POST" action="{{ route('student.update') }}" class="mt-6 space-y-4 hidden">
            @csrf
            @method('PUT')

            <!-- Student Table Info -->
            <div>
                <label for="student_id" class="block text-sm font-medium text-gray-500">Student ID</label>
                <input type="text" name="student_id" id="student_id"
                    value="{{ old('student_id', $student->student_id) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('student_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- User Table Info -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-500">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nickname" class="block text-sm font-medium text-gray-500">Nickname</label>
                <input type="text" name="nickname" id="nickname" value="{{ old('nickname', $user->nickname) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('nickname')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="line_id" class="block text-sm font-medium text-gray-500">Line ID</label>
                <input type="text" name="line_id" id="line_id" value="{{ old('line_id', $user->line_id) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('line_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-500">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number"
                    value="{{ old('phone_number', $user->phone_number) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('phone_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Fields -->
            <div class="border-t border-gray-200 pt-4">
                <h3 class="text-lg font-medium text-gray-800 mb-2">Update Password</h3>

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-500">Current
                        Password</label>
                    <input type="password" name="current_password" id="current_password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-500">New Password</label>
                    <input type="password" name="password" id="password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-500">Confirm New
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-[#8E5C65] text-white font-bold py-2 px-4 rounded-md hover:bg-[#8E5C65]">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-layout>

<script>
    // JavaScript to toggle between viewing and editing
    document.getElementById('edit-button').addEventListener('click', function() {
        document.getElementById('profile-info').classList.toggle('hidden');
        document.getElementById('edit-form').classList.toggle('hidden');
    });
</script>
