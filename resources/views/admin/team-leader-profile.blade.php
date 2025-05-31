{{-- filepath: /home/nastrona/Music/ILC-Web/resources/views/admin/team-leader-profile.blade.php --}}
<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Team Leader Profile</h2>

        <div class="space-y-4">
            <!-- Team Leader Image -->
            <div>
                <label class="text-sm font-medium text-gray-500">Team Leader Image:</label>
                @if($teamLeader->teamleader_image)
                    <a href="{{ asset('teamleader_image/' . $teamLeader->teamleader_image) }}" target="_blank">
                        <img src="{{ asset('teamleader_image/' . $teamLeader->teamleader_image) }}" alt="Team Leader Image" class="w-24 h-24 rounded-full object-cover mt-2">
                    </a>
                @else
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center border-2 border-gray-200 mt-2">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">No image available</p>
                @endif
            </div>

            <!-- Name -->
            <div>
                <label class="text-sm font-medium text-gray-500">Name:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->user->name }}</p>
            </div>

            <!-- Nickname -->
            <div>
                <label class="text-sm font-medium text-gray-500">Nickname:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->user->nickname ?? 'N/A' }}</p>
            </div>

            <!-- Team Name -->
            <div>
                <label class="text-sm font-medium text-gray-500">Team Name:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->team_name ?? 'N/A' }}</p>
            </div>

            <!-- Team Description -->
            <div>
                <label class="text-sm font-medium text-gray-500">Team Description:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->team_description ?? 'N/A' }}</p>
            </div>

            <!-- Email -->
            <div>
                <label class="text-sm font-medium text-gray-500">Email:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->user->email }}</p>
            </div>

            <!-- Line ID -->
            <div>
                <label class="text-sm font-medium text-gray-500">Line ID:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->user->line_id ?? 'N/A' }}</p>
            </div>

            <!-- Phone Number -->
            <div>
                <label class="text-sm font-medium text-gray-500">Phone Number:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->user->phone_number ?? 'N/A' }}</p>
            </div>

            <!-- User Role -->
            <div>
                <label class="text-sm font-medium text-gray-500">Role:</label>
                <p class="text-lg font-semibold text-gray-800">{{ ucfirst(str_replace('_', ' ', $teamLeader->user->role)) }}</p>
            </div>

            <!-- Account Created -->
            <div>
                <label class="text-sm font-medium text-gray-500">Account Created:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $teamLeader->user->created_at->format('M d, Y') }}</p>
            </div>
    </div>
</x-layout>