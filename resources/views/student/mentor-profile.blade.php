<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Mentor Profile</h2>

        <div class="space-y-4">
            <div>
                <label class="text-sm font-medium text-gray-500">Mentor Image:</label>
                <a href="{{ asset('mentor_image/' . $mentor->mentor_image) }}" target="_blank">
                    <img src="{{ asset('mentor_image/' . $mentor->mentor_image) }}" alt="Mentor Image" class="w-24 h-24 rounded-full object-cover">
                </a>
            </div>
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
                <p class="text-lg font-semibold text-gray-800">{{ $mentor->user->line_id ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Phone Number:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $mentor->user->phone_number ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</x-layout>
