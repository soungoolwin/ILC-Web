<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Mentor Profile</h2>

        <div class="mt-6 space-y-4">
            <div>
                <label class="text-sm font-medium text-gray-500">Name:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $mentor->user->name }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Nickname:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $mentor->user->nickname }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Email:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $mentor->user->email }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Line ID:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $mentor->user->line_id }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Phone Number:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $mentor->user->phone_number }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Mentor ID:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $mentor->mentor_id }}</p>
            </div>
        </div>
    </div>
</x-layout>
