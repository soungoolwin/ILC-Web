<x-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Team Leaders Timetable</h2>

        <!-- Search Form -->
         <form method="GET" action="{{ route('admin.team_leaders_timetable')}}" class="space-y-4 mb-6">
  
            <div class="flex items-center space-x-4">
                <!-- Day -->
                <div>
                    <label for="day" class="block text-xs lg:text-sm font-semibold text-gray-600 mb-1 ml-4">Day</label>
                    <select name="day" id="day"
                        class="w-full border border-gray-300 text-xs lg:text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
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
                    <label for="time_slot" class="block text-xs lg:text-sm font-semibold text-gray-600 mb-1 ml-4">Time Slot</label>
                    <select name="time_slot" id="time_slot"
                        class="w-full border border-gray-300 text-xs lg:text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                        <option value="">All Time Slots</option>
                        @foreach (['09:00-11:00', '11:00-13:00', '13:00-15:00', '15:00-17:00', '17:00-20:00'] as $slot)
                            <option value="{{ $slot }}" {{ request('time_slot') === $slot ? 'selected' : '' }}>
                                {{ $slot }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Search by ID-->
                <div> 
                    <label for="team_leader_id" class="block text-xs lg:text-sm font-semibold text-gray-600 mb-1 ml-4">Search by Student ID</label>
                    <input type="text" name="team_leader_id" id="team_leader_id" value="{{ request('team_leader_id') }}"
                        class="w-full border border-gray-300 text-xs lg:text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                </div>
                <!-- Search Button -->
            <div>
                <button type="submit" class="w-full block mt-6 bg-[#7D3C98] text-white text-xs lg:text-sm font-bold py-2 px-4 rounded-lg transition">
                    Search
                </button>
                
            </div>
            <div>
                <a href="{{ route('admin.team_leaders_timetable') }}" class="w-full block mt-6 bg-red-600 text-white text-xs lg:text-sm font-bold py-2 px-4 rounded-lg text-center hover:bg-gray-600 transition">
                    Reset
                </a>
            </div>
            </div>
        </form>

        <!-- Display Team Leaders Timetables -->
        @if ($teamLeaderTimetables->count() > 0)
        <div class="w-full flex justify-center items-center mx-auto">
            <table class="table-auto text-[10px] lg:text-base w-full border-collapse border border-gray-300">
                <thead class="bg-[#7D3C98] text-white rounded-xl shadow-md">
                    <tr class="text-[10px] lg:text-base">
                        <th class="border border-gray-300 px-2 py-2">Day</th>
                        <th class="border border-gray-300 px-2 py-2">Time Slot</th>
                        <th class="border border-gray-300 px-4 py-2">TL Name</th>
                        <th class="border border-gray-300 px-4 py-2">Nickname</th>
                        <th class="border border-gray-300 px-4 py-2">Line ID</th>
                        <th class="border border-gray-300 px-2 py-2">Student ID</th>
                        <th class="border border-gray-300 px-4 py-2">Faculty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teamLeaderTimetables as $timetable)
                        <tr class="text-[10px] lg:text-base hover:bg-gray-100 transition-colors duration-200">
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
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                {{ $timetable->teamLeader->user->line_id ?? 'N/A' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                {{ $timetable->teamLeader->team_leader_id ?? 'N/A' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                {{ $timetable->teamLeader->user->faculty ?? 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p class="text-center text-gray-600">No records found for the selected criteria.</p>
        @endif
    </div>
</x-layout>
