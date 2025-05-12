<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6 w-1/2">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Profile Information</h2>
            <!-- Edit Button -->
            <button id="edit-button" class="text-blue-600 hover:text-blue-800">
                Edit
            </button>
        </div>

        <!-- Mentor Image Section -->
        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-800">Profile Picture</h3>
            <div class="flex items-center space-x-4 mt-4">
                @if (optional($mentor)->mentor_image)
                    <img src="{{ asset('mentor_image/' . $mentor->mentor_image) }}" alt="Mentor Image"
                        class="w-24 h-24 rounded-full object-cover">
                @else
                    <p class="text-gray-500">No image available</p>
                @endif

                <!-- Image Upload Form -->
                <form method="POST" action="{{ route('mentor.image.upload') }}" enctype="multipart/form-data" class="flex items-center space-x-2">
                    @csrf
                    <input type="file" name="mentor_image" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border file:border-gray-300 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                    <button type="submit"
                        class="bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-800">
                        Upload
                    </button>
                </form>
            </div>
            @error('mentor_image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded-md mt-4">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-md mt-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profile Info -->
        <div id="profile-info" class="mt-6 space-y-4 ">
            <!-- Mentor Table Info -->
            <div>
                <label class="text-sm font-medium text-gray-500">Mentor ID:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $mentor->mentor_id }}</p>
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
        <form id="edit-form" method="POST" action="{{ route('mentor.update') }}" class="mt-6 space-y-4 hidden">
            @csrf
            @method('PUT')

            <!-- Mentor Table Info -->
            <div>
                <label for="mentor_id" class="block text-sm font-medium text-gray-500">Mentor ID</label>
                <input type="text" name="mentor_id" id="mentor_id" value="{{ old('mentor_id', $mentor->mentor_id) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('mentor_id')
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
