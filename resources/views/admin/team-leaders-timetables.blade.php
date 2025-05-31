<x-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Team Leaders Timetable</h2>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.team_leaders_timetable') }}" class="space-y-4 mb-6">
            <div class="flex items-center space-x-4">
                <!-- Day -->
                <div>
                    <label for="day" class="block text-sm font-semibold text-gray-600">Day</label>
                    <select name="day" id="day"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                        <option value="">All Days</option>
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $dayOption)
                            <option value="{{ $dayOption }}" {{ request('day') === $dayOption ? 'selected' : '' }}>
                                {{ $dayOption }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Time Slot -->
                <div>
                    <label for="time_slot" class="block text-sm font-semibold text-gray-600">Time Slot</label>
                    <select name="time_slot" id="time_slot"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                        <option value="">All Time Slots</option>
                        @foreach (['09:00-11:00', '11:00-13:00', '13:00-15:00', '15:00-17:00', '17:00-20:00'] as $slot)
                            <option value="{{ $slot }}" {{ request('time_slot') === $slot ? 'selected' : '' }}>
                                {{ $slot }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Search Button -->
            <div>
                <button type="submit" class="w-full bg-[#7D3C98] text-white font-bold py-2 px-4 rounded-lg transition">
                    Search
                </button>
            </div>
        </form>

        <!-- Display Team Leaders Timetables -->
        @if ($teamLeaderTimetables->count() > 0)
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Day</th>
                        <th class="border border-gray-300 px-4 py-2">Time Slot</th>
                        <th class="border border-gray-300 px-4 py-2">Team Leader Name</th>
                        <th class="border border-gray-300 px-4 py-2">Team Leader Nickname</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teamLeaderTimetables as $timetable)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $timetable->day }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $timetable->time_slot }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <a href="{{ route('admin.team_leaders.show', $timetable->teamLeader->id) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $timetable->teamLeader->user->name ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                {{ $timetable->teamLeader->user->nickname ?? 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-gray-600">No records found for the selected criteria.</p>
        @endif
    </div>
</x-layout>
