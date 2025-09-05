<x-layout>
    <div class=" mx-auto bg-white shadow-lg rounded-lg p-6 mt-6 mb-8 w-4/5 lg:w-1/2">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Profile Information</h2>
            <!-- Edit Button -->
            <button id="edit-button" class="text-blue-600 hover:text-blue-800">
                Edit
            </button>
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
        <div id="profile-info" class="mt-6 space-y-4">
            <!-- Admin Table Info -->
            <div>
                <label class="text-sm font-medium text-gray-500">Admin ID:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $admin->admin_id }}</p>
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
        <form id="edit-form" method="POST" action="{{ route('admin.update') }}" class="mt-6 space-y-4 hidden">
            @csrf
            @method('PUT')

            <!-- Admin Table Info -->
            <div>
                <label for="admin" class="block text-sm font-medium text-gray-500">Admin ID</label>
                <input type="text" name="admin_id" id="admin_id" value="{{ old('admin_id', $admin->admin_id) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- User Table Info -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-500">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="nickname" class="block text-sm font-medium text-gray-500">Nickname</label>
                <input type="text" name="nickname" id="nickname" value="{{ old('nickname', $user->nickname) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="line_id" class="block text-sm font-medium text-gray-500">Line ID</label>
                <input type="text" name="line_id" id="line_id" value="{{ old('line_id', $user->line_id) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-500">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number"
                    value="{{ old('phone_number', $user->phone_number) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Password Fields -->
            <div class="border-t border-gray-200 pt-4">
                <h3 class="text-lg font-medium text-gray-800 mb-2">Update Password</h3>

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-500">Current
                        Password</label>
                    <input type="password" name="current_password" id="current_password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-500">New Password</label>
                    <input type="password" name="password" id="password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-500">Confirm New
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-[#7D3C98] text-white font-bold py-2 px-4 rounded-md hover:bg-[#7D3C98]">
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
