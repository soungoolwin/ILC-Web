<x-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Team Leaders</h2>

        <!-- Search Form -->
        <form method="GET" action="{{ route('dashboard.team_leaders') }}" class="mb-6">
            <div class="flex-column items-center space-x-4">
                <div>
                    <label for="team_leader_id" class="flex text-xs ml-6 mb-2 font-semibold text-gray-600">Search by Team Leader ID</label>
                </div>
                    <input type="text" name="team_leader_id" id="team_leader_id" value="{{ $request->team_leader_id }}"
                        placeholder="Enter Team Leader ID"
                        class="w-1/4 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                    <button type="submit" class="bg-[#7D3C98] text-white px-4 py-2 rounded-lg  transition">
                        Search
                    </button>
            </div>
        </form>

        <!-- Display Team Leaders -->
        @if ($teamLeaders->count() > 0)
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead class="bg-[#7D3C98] text-white rounded-xl shadow-md">
                    <tr class="text-sm">
                        <th class="border border-gray-300 px-4 py-2">Team Leader ID</th>
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Nickname</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Phone Number</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teamLeaders as $teamLeader)
                        <tr class="text-sm hover:bg-gray-100 transition-colors duration-200">
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $teamLeader->team_leader_id }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $teamLeader->user->name }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $teamLeader->user->nickname }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $teamLeader->user->email }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                {{ $teamLeader->user->phone_number ?? 'N/A' }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <form method="POST"
                                    action="{{ route('dashboard.team_leaders.delete', $teamLeader->id) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this team leader?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-6">
                {{ $teamLeaders->links() }}
            </div>
        @else
            <p class="text-center text-gray-600">No team leaders found matching the search criteria.</p>
        @endif
    </div>
</x-layout>
