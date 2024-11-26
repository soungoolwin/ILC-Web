<x-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Check Appointment Availability</h2>

        <!-- Search Form -->
        <form method="GET" action="{{ route('appointments.availability') }}" class="space-y-4 mb-6">
            <div class="flex items-center space-x-4">
                <!-- Week Number -->
                <div>
                    <label for="week_number" class="block text-sm font-semibold text-gray-600">Week Number</label>
                    <input type="number" name="week_number" id="week_number" value="{{ request('week_number') }}"
                        placeholder="e.g., 1"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                </div>

                <!-- Table Number -->
                <div>
                    <label for="table_number" class="block text-sm font-semibold text-gray-600">Table Number</label>
                    <input type="number" name="table_number" id="table_number" value="{{ request('table_number') }}"
                        placeholder="e.g., 5"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                </div>

                <!-- Time Slot -->
                <div>
                    <label for="time_slot" class="block text-sm font-semibold text-gray-600">Time Slot</label>
                    <select name="time_slot" id="time_slot"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                        <option value="">All Time Slots</option>
                        @foreach (['09:00-09:30', '09:30-10:00', '10:00-10:30', '10:30-11:00', '11:00-11:30', '11:30-12:00', '12:00-12:30', '12:30-13:00', '13:00-13:30', '13:30-14:00'] as $slot)
                            <option value="{{ $slot }}" {{ request('time_slot') === $slot ? 'selected' : '' }}>
                                {{ $slot }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Day -->
                <div>
                    <label for="day" class="block text-sm font-semibold text-gray-600">Day</label>
                    <select name="day" id="day"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                        <option value="">All Days</option>
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                            <option value="{{ $day }}" {{ request('day') === $day ? 'selected' : '' }}>
                                {{ $day }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Search Button -->
            <div>
                <button type="submit" class="w-full bg-[#8E5C65] text-white font-bold py-2 px-4 rounded-lg transition">
                    Search
                </button>
            </div>
        </form>

        <!-- Display Available Timetables -->
        @if (count($availableTimetables) > 0)
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Week Number</th>
                        <th class="border border-gray-300 px-4 py-2">Day</th>
                        <th class="border border-gray-300 px-4 py-2">Time Slot</th>
                        <th class="border border-gray-300 px-4 py-2">Table Number</th>
                        <th class="border border-gray-300 px-4 py-2">Reserved?</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($availableTimetables as $timetable)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $timetable['week_number'] }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $timetable['day'] }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $timetable['time_slot'] }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $timetable['table_number'] }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $timetable['is_reserved'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-gray-600">No available timetables match your search criteria.</p>
        @endif
    </div>
</x-layout>