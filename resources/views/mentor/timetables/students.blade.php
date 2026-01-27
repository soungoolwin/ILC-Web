<x-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Search Students for a Timetable</h2>

        <!-- Search Form -->
        <form method="GET" action="{{ route('mentor.timetables.students') }}" class="space-y-4 mb-6">
            <div class="grid grid-cols-2 gap-4">
                <!-- Week Number ---- I changed the week numbers from  -->
                <div>
                    <label for="week_number" class="block text-sm font-semibold text-gray-600">Week Number</label>
                    <select name="week_number" id="week_number"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                        <option value="">Select Week</option>
                        @foreach (range(4, 13) as $week)
                            <option value="{{ $week }}" {{ $request->week_number == $week ? 'selected' : '' }}>
                                Week {{ $week }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Day -->
                <div>
                    <label for="day" class="block text-sm font-semibold text-gray-600">Day</label>
                    <select name="day" id="day"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                        <option value="">Select Day</option>
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                            <option value="{{ $day }}" {{ $request->day == $day ? 'selected' : '' }}>
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
                        <option value="">Select Time Slot</option>
                        @foreach (['09:00-09:30', '09:30-10:00', '10:00-10:30', '10:30-11:00', '11:00-11:30', '11:30-12:00', '12:00-12:30', '12:30-13:00', '13:00-13:30', '13:30-14:00', '14:00-14:30', '14:30-15:00', '15:00-15:30', '15:30-16:00', '16:00-16:30', '16:30-17:00'] as $slot)
                            <option value="{{ $slot }}" {{ $request->time_slot == $slot ? 'selected' : '' }}>
                                {{ $slot }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Table Number -->
                <div>
                    <label for="table_number" class="block text-sm font-semibold text-gray-600">Table Number</label>
                    <select name="table_number" id="table_number"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                        <option value="">Select Table</option>
                        @foreach (range(1, 10) as $table)
                            <option value="{{ $table }}"
                                {{ $request->table_number == $table ? 'selected' : '' }}>
                                Table {{ $table }}
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

        <!-- Display Results -->
        @if ($students->isNotEmpty())
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Students</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <a href="{{ route('mentor.students.show', $student->id) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $student->user->name ?? 'N/A' }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-gray-600">No students registered for the specified timetable.</p>
        @endif
    </div>

    <script>
    const tableSelect = document.getElementById('table_number');
    const timeSelect = document.getElementById('time_slot');

    timeSelect.addEventListener('change', function () {
        const selectedTime = this.value;
        let tableCount = 12;

        // Show only 2 tables for 09:00-10:00 and 10:00-11:00
        if (selectedTime === '09:00-09:30' || selectedTime === '09:30-10:00' || selectedTime === '10:00-10:30' || selectedTime === '10:30-11:00') {
            tableCount = 2;
        }

        if (selectedTime === '15:00-15:30' || selectedTime === '15:30-16:00' || selectedTime === '16:00-16:30' || selectedTime === '16:30-17:00') {
            tableCount = 7;
        }

        // Clear current options
        tableSelect.innerHTML = '<option value="">Select a Table</option>';

        // Add new options
        for (let i = 1; i <= tableCount; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = 'Table ' + i;
            tableSelect.appendChild(option);
        }
    });
</script>

</x-layout>
