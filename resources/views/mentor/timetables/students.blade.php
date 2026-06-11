<x-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Your Students</h2>

        @if (!$reservedTimetable)
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-md">
                You haven't reserved a timetable yet.
                <a href="{{ route('mentor.timetables.create') }}" class="font-semibold underline">
                    Reserve one here
                </a>
                to see your students.
            </div>
        @else
            @php
                $start = explode('-', $reservedTimetable->time_slot)[0];
                $hour = (int) explode(':', $start)[0];
                $hourlySlot = sprintf('%02d:00-%02d:00', $hour, $hour + 1);
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-xs font-semibold uppercase text-gray-500">Day</p>
                    <p class="text-lg font-bold text-gray-800 mt-1">{{ $reservedTimetable->day }}</p>
                </div>
                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-xs font-semibold uppercase text-gray-500">Time Slot</p>
                    <p class="text-lg font-bold text-gray-800 mt-1">{{ $hourlySlot }}</p>
                </div>
                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-xs font-semibold uppercase text-gray-500">Table Number</p>
                    <p class="text-lg font-bold text-gray-800 mt-1">Table {{ $reservedTimetable->table_number }}</p>
                </div>
            </div>

            <!-- Week Filter -->
            <form method="GET" action="{{ route('mentor.timetables.students') }}" class="flex items-end gap-4 mb-6">
                <div class="flex-1 max-w-xs">
                    <label for="week_number" class="block text-sm font-semibold text-gray-600 mb-1">Filter by Week</label>
                    <select name="week_number" id="week_number"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                        <option value="">All Weeks</option>
                        @foreach (range(4, 13) as $week)
                            <option value="{{ $week }}" {{ $request->week_number == $week ? 'selected' : '' }}>
                                Week {{ $week }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-[#7D3C98] text-white font-bold py-2 px-4 rounded-lg transition">
                    Apply
                </button>
                @if ($request->filled('week_number'))
                    <a href="{{ route('mentor.timetables.students') }}"
                       class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg transition hover:bg-gray-300">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Display Results -->
            @if ($students->isNotEmpty())
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-[#7D3C98] text-white">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">Student</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Student ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr class="hover:bg-gray-100 transition-colors duration-200">
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route('mentor.students.show', $student->id) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $student->user->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $student->student_id ?? 'N/A' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center text-gray-600">
                    No students {{ $request->filled('week_number') ? 'for week ' . $request->week_number : 'registered for your timetable' }}.
                </p>
            @endif
        @endif
    </div>
</x-layout>
