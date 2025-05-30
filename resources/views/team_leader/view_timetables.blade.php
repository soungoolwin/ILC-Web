<x-layout>
    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">View Timetables</h2>

        <!-- Search Form -->
        <form method="GET" action="{{ route('team_leader.view_timetables') }}" class="space-y-4 mb-6">
            <div class="grid grid-cols-4 gap-4">
                <!-- Week Number -->
                <div>
                    <label for="week_number" class="block text-sm font-semibold text-gray-600">Week Number</label>
                    <select name="week_number" id="week_number"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                        <option value="">All Weeks</option>
                        @for ($i = 1; $i <= 16; $i++)
                            <option value="{{ $i }}" {{ request('week_number') == $i ? 'selected' : '' }}>
                                Week {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Day -->
                <div>
                    <label for="day" class="block text-sm font-semibold text-gray-600">Day</label>
                    <select name="day" id="day"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                        <option value="">All Days</option>
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                            <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>
                                {{ $day }}
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
                        @foreach (range(9, 19) as $hour)
                            @php
                                $startTime = sprintf('%02d:00', $hour);
                                $midTime = sprintf('%02d:30', $hour);
                                $nextHour = sprintf('%02d:00', $hour + 1);
                            @endphp
                            <option value="{{ $startTime }}-{{ $midTime }}"
                                {{ request('time_slot') == "$startTime-$midTime" ? 'selected' : '' }}>
                                {{ $startTime }}-{{ $midTime }}
                            </option>
                            <option value="{{ $midTime }}-{{ $nextHour }}"
                                {{ request('time_slot') == "$midTime-$nextHour" ? 'selected' : '' }}>
                                {{ $midTime }}-{{ $nextHour }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Table Number -->
                <div>
                    <label for="table_number" class="block text-sm font-semibold text-gray-600">Table Number</label>
                    <input type="number" name="table_number" id="table_number" value="{{ request('table_number') }}"
                        placeholder="e.g., 5"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                </div>
            </div>

            <!-- Search Button -->
            <div>
                <button type="submit" class="w-full bg-[#7D3C98] text-white font-bold py-2 px-4 rounded-lg transition">
                    Search
                </button>
            </div>
        </form>

        <!-- Display Timetables -->
        @if ($timetables->isNotEmpty())
            @foreach ($timetables as $mentorName => $mentorTimetables)
                @php
                    // Get Mentor ID from the first timetable entry
                    $mentorId = optional($mentorTimetables->first()->mentor)->id;
                @endphp

                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">
                        <a href="{{ route('team_leader.mentors.show', $mentorId) }}"
                            class="text-blue-600 hover:underline">
                            {{ $mentorName }}
                        </a>
                    </h3>

                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">Time Slot</th>
                                <th class="border border-gray-300 px-4 py-2">Table Number</th>
                                <th class="border border-gray-300 px-4 py-2">Students</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mentorTimetables as $timetable)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        {{ $timetable->time_slot }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        {{ $timetable->table_number }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <ul class="text-center">
                                            @forelse ($timetable->appointments as $appointment)
                                                <li>
                                                    <a href="{{ route('team_leader.students.show', $appointment->student->id) }}"
                                                        class="text-blue-600 hover:underline">
                                                        {{ $appointment->student->user->name ?? 'N/A' }}
                                                    </a>
                                                </li>
                                            @empty
                                                <li>No students registered</li>
                                            @endforelse
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @elseif ($request->all())
            <p class="text-center text-gray-600">No timetables found matching your search criteria.</p>
        @endif
    </div>
</x-layout>
