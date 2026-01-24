<x-layout>
    <div class="min-h-screen bg-gray-50 py-4 px-4 sm:px-6 lg:px-8">
    <div class="w-full mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Mentor-Student Timetable</h2>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.mentor_students_timetable') }}" class="space-y-4 mb-6">
            <div class="flex items-left space-x-4">
                <!-- Day -->
                <div>
                    <label for="day" class="block text-xs lg:text-sm font-semibold text-gray-600">Day</label>
                    <select name="day" id="day"
                        class="w-full text-xs lg:text-sm border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
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
                    <label for="time_slot" class="block text-xs lg:text-sm font-semibold text-gray-600">Time Slot</label>
                    <select name="time_slot" id="time_slot"
                        class="text-xs lg:text-sm w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                        <option value="">All Time Slots</option>
                        @foreach (['09:00-09:30', '09:30-10:00', '10:00-10:30', '10:30-11:00', '11:00-11:30', '11:30-12:00', '12:00-12:30', '12:30-13:00', '13:00-13:30', '13:30-14:00', '14:00-14:30', '14:30-15:00', '15:00-15:30', '15:30-16:00', '16:00-16:30', '16:30-17:00'] as $slot)
                            <option value="{{ $slot }}" {{ request('time_slot') === $slot ? 'selected' : '' }}>
                                {{ $slot }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Week Number -->
                <div>
                    <label for="week_number" class="block text-xs lg:text-sm font-semibold text-gray-600 text-nowrap">Week Number</label>
                    <select name="week_number" id="week_number"
                        class="text-xs lg:text-sm w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                        <option value="">All Weeks</option>
                        @foreach (range(4, 13) as $week)
                            <option value="{{ $week }}" {{ request('week_number') == $week ? 'selected' : '' }}>
                                Week {{ $week }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Search Button -->
            <div>
                <button type="submit" class=" block mt-5 w-full bg-[#7D3C98] text-white font-bold text-xs lg:text-sm py-2 px-4 rounded-lg transition">
                    Search
                </button>
            </div>
            </div>

            
        </form>

        <!-- Display Mentor-Student Timetables -->
        @if ($timetables->count() > 0)
        <div class="w-full flex justify-center items-center mx-auto" >
            <table class="table-auto text-[10px] lg:text-base w-full border-collapse border border-gray-300">
                <thead class="bg-[#7D3C98] text-white rounded-xl shadow-md">
                    <tr class="text-[10px] lg:text-base">
                        <th class="border border-gray-300 px-2 py-2">Week</th>
                        <th class="border border-gray-300 px-2 py-2">Day</th>
                        <th class="border border-gray-300 px-4 py-2">Time Slot</th>
                        <th class="border border-gray-300 px-4 py-2 max-w-[80px]">Mentor</th>
                        <th class="border border-gray-300 px-8 py-2 min-w-[150px]">Students</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timetables as $timetable)
                        <tr class="text-[10px] lg:text-base hover:bg-gray-100 transition-colors duration-200">
                            <td class="border border-gray-300 px-2 py-2 text-center">{{ $timetable->week_number }}</td>
                            <td class="border border-gray-300 px-2 py-2 text-center">{{ $timetable->day }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $timetable->time_slot }}</td>
                            <td class="border border-gray-300 px-4 py-2 max-w-[80px] text-center">
                                <a href="{{ route('admin.mentors.show', $timetable->mentor->id) }}"
                                    class="text-black hover:underline hover:font-bold">
                                    {{ $timetable->mentor->user->name ?? 'N/A' }}
                                    ({{ $timetable->mentor->user->line_id ?? 'N/A' }})
                                </a>
                            </td>
                            <td class="border border-gray-300 px-8py-2 text-center text-[10px] lg:text-base">
                                @if ($timetable->appointments->isEmpty())
                                    <span>N/A</span>
                                @else
                                    @foreach ($timetable->appointments as $appointment)
                                        <div>
                                            <a href="{{ route('admin.students.show', $appointment->student->id) }}"
                                                class="text-black hover:font-bold hover:underline">
                                                {{ $appointment->student->user->name ?? 'N/A' }}
                                                ({{ $appointment->student->user->line_id ?? 'N/A' }})
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
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
</div>
</x-layout>
