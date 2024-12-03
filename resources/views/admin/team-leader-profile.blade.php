<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Team Leader Profile</h2>

        <!-- Profile Information -->
        <div class="space-y-4">
            <div>
                <label class="text-sm font-medium text-gray-500">Name:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->user->name }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Nickname:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->user->nickname }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Email:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->user->email }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">TeamLeader ID:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->team_leader_id ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Line ID:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->user->line_id ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Phone Number:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->user->phone_number ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</x-layout>
