<x-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Make an Appointment</h2>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded-md mb-6">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('student.appointments.store') }}" class="space-y-5">
            @csrf

            <!-- Week Number -->
            <div>
                <label for="week_number" class="block text-sm font-semibold text-gray-600 mb-1">Week Number</label>
                <select name="week_number" id="week_number"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                    required>
                    <option value="">Select a Week</option>
                    @foreach (range(2, 6) as $week)
                        <option value="{{ $week }}">{{ $week }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Day -->
            <div>
                <label for="day" class="block text-sm font-semibold text-gray-600 mb-1">Day</label>
                <select name="day" id="day"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                    required>
                    <option value="">Select a Day</option>
                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Time Slot -->
            <div>
                <label for="time_slot" class="block text-sm font-semibold text-gray-600 mb-1">Time Slot</label>
                <select name="time_slot" id="time_slot"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                    required>
                    <option value="">Select a Time Slot</option>
                    @foreach (['09:00-09:30', '09:30-10:00', '10:00-10:30', '10:30-11:00', '11:00-11:30', '11:30-12:00', '12:00-12:30', '12:30-13:00', '13:00-13:30', '13:30-14:00', '14:00-14:30', '14:30-15:00', '15:00-15:30', '15:30-16:00', '16:00-16:30', '16:30-17:00'] as $slot) <!-- 9-5 only for summer you can change the time slots here - Dennis -->
                        <option value="{{ $slot }}">{{ $slot }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Table Number -->
            <div>
                <label for="table_number" class="block text-sm font-semibold text-gray-600 mb-1">Table Number</label>
                <select name="table_number" id="table_number"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                    required>
                    <option value="">Select a Table</option>
                    @foreach (range(1, 4) as $table)
                        <option value="{{ $table }}">Table {{ $table }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->

            <div class="flex items-center justify-between">
                <!-- Reserve Button -->
                <button type="submit"
                    class="bg-[#7D3C98] text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition">
                    Make Appointment
                </button>

                <!-- Check Availability Button -->
                <a href="{{ route('student.appointments.availability') }}"
                    class="bg-[#7D3C98] text-white font-bold py-3 px-4 rounded-lg shadow-lg transition">
                    Check Availability
                </a>
            </div>
        </form>
    </div>
</x-layout>

<!-- JavaScript to dynamically change table options based on time slot selection -->
<script>
    const tableSelect = document.getElementById('table_number');
    const timeSelect = document.getElementById('time_slot');

    timeSelect.addEventListener('change', function () {
        const selectedTime = this.value;
        let tableCount = 4;

        // Show only 2 tables for 09:00-09:30, 9:30-10:00, 10:00-10:30, and 10:30-11:00
        if (selectedTime === '09:00-09:30' || selectedTime === '09:30-10:00' || selectedTime === '10:00-10:30' || selectedTime === '10:30-11:00') {
            tableCount = 2;
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
