<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Check Availability</h2>

        <!-- Search Form -->
        <form method="GET" action="{{ route('team_leader.timetable.availability') }}" class="space-y-4 mb-6">
            <div class="grid grid-cols-2 gap-4">
                <!-- Day -->
                <div>
                    <label for="day" class="block text-sm font-semibold text-gray-600">Day</label>
                    <select name="day" id="day"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                        <option value="">Select a Day</option>
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
                        <option value="">Select a Time Slot</option>
                        @foreach (['09:00-11:00', '11:00-13:00', '13:00-15:00', '15:00-17:00',] as $slot) <!-- // add  '17:00-20:00' on main semesters -->
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

        <!-- Availability Results -->
        @if ($availability)
            <div class="mt-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Availability for {{ $availability['day'] }} -
                    {{ $availability['time_slot'] }}</h3>
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Time Slot</th>
                            <th class="border border-gray-300 px-4 py-2">Reserved</th>
                            <th class="border border-gray-300 px-4 py-2">Available</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $availability['time_slot'] }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $availability['reserved'] }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $availability['available'] }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @elseif ($request->has('day') || $request->has('time_slot'))
            <p class="text-center text-gray-600">No results found for your search criteria.</p>
        @endif
    </div>
</x-layout>
