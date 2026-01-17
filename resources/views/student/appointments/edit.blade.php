<x-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Appointment</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded-md mb-6">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('student.appointments.update', $appointment->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            @php
                $slot = $appointment->timetable;
            @endphp

            <!-- Week Number -->
            <div>
                <label for="week_number">Week Number</label>
                <select name="week_number" required class="w-full border rounded px-4 py-2">
                    @foreach (range(4, 13) as $week)
                        <option value="{{ $week }}" {{ $slot->week_number == $week ? 'selected' : '' }}>
                            {{ $week }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Day -->
            <div>
                <label for="day">Day</label>
                <select name="day" required class="w-full border rounded px-4 py-2">
                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                        <option value="{{ $day }}" {{ $slot->day == $day ? 'selected' : '' }}>
                            {{ $day }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Time Slot -->
            <div>
                <label for="time_slot">Time Slot</label>
                <select id="time_slot" name="time_slot" required class="w-full border rounded px-4 py-2">
                    @foreach ([
                        '09:00-09:30','09:30-10:00','10:00-10:30','10:30-11:00','11:00-11:30','11:30-12:00',
                        '12:00-12:30','12:30-13:00','13:00-13:30','13:30-14:00','14:00-14:30','14:30-15:00',
                        '15:00-15:30','15:30-16:00','16:00-16:30','16:30-17:00'
                    ] as $slotTime)
                        <option value="{{ $slotTime }}" {{ $slot->time_slot == $slotTime ? 'selected' : '' }}>
                            {{ $slotTime }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Table Number -->
            <div>
                <label for="table_number">Table Number</label>
                <select id= "table_number" name="table_number" required class="w-full border rounded px-4 py-2">
                    @foreach (range(1, 5) as $table)
                        <option value="{{ $table }}" {{ $slot->table_number == $table ? 'selected' : '' }}>
                            Table {{ $table }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between">
                <button type="submit" class="bg-[#7D3C98] text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition">Update</button>
                <a href="{{ route('student.appointments.availability') }}" class="bg-[#7D3C98] text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition">
                    Check Availability
                </a>
            </div>
        </form>
    </div>
</x-layout>

<script>
    const tableSelect = document.getElementById('table_number');
    const timeSelect = document.getElementById('time_slot');

    timeSelect.addEventListener('change', function () {
        const selectedTime = this.value;
        let tableCount = 5;

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