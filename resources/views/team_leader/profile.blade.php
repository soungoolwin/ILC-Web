<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Profile Information</h2>
            <!-- Edit Button -->
            <button id="edit-button" class="text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 17l-4 4m0 0l-4-4m4 4V3m7 6l-4 4m0 0l4-4m-4 4H3" />
                </svg>
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
            <!-- Team Leader Table Info -->
            <div>
                <label class="text-sm font-medium text-gray-500">Team Leader ID:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->team_leader_id }}</p>
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
        <form id="edit-form" method="POST" action="{{ route('team_leader.update') }}" class="mt-6 space-y-4 hidden">
            @csrf
            @method('PUT')

            <!-- Team Leader Table Info -->
            <div>
                <label for="team_leader_id" class="block text-sm font-medium text-gray-500">Team Leader ID</label>
                <input type="text" name="team_leader_id" id="team_leader_id"
                    value="{{ old('team_leader_id', $teamLeader->team_leader_id) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('team_leader_id')
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
                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700">
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