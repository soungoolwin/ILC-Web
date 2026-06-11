<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Mentor Reservation</h2>
        <p class="text-sm text-gray-600 mb-4">
            Mentor:
            <span class="font-semibold">{{ $mentor->user->name ?? 'N/A' }}</span>
            ({{ $mentor->mentor_id ?? 'N/A' }})
        </p>

        @if (session('info'))
            <div class="bg-blue-100 text-blue-800 p-4 rounded-md mb-6">
                {{ session('info') }}
            </div>
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

        <form method="POST" action="{{ route('admin.mentor_timetable.update', $mentor->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Scope: all weeks vs single week -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <p class="text-sm font-semibold text-gray-700 mb-2">Apply changes to:</p>
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="scope" value="all" class="scope-radio"
                            {{ (old('scope', $defaultScope) === 'all') ? 'checked' : '' }}>
                        <span class="text-sm text-gray-700">All weeks</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="scope" value="week" class="scope-radio"
                            {{ (old('scope', $defaultScope) === 'week') ? 'checked' : '' }}>
                        <span class="text-sm text-gray-700">Only week:</span>
                    </label>
                    <select name="week_number" id="week_number"
                        class="w-32 border border-gray-300 rounded-lg px-3 py-1 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition disabled:bg-gray-100 disabled:text-gray-400">
                        @foreach ($weekNumbers as $week)
                            <option value="{{ $week }}" {{ (string) old('week_number', $defaultWeek) === (string) $week ? 'selected' : '' }}>
                                Week {{ $week }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Each timetable is stored as one instance per week. Choose whether to change every week or just one.
                </p>
            </div>

            <div>
                <label for="day" class="block text-sm font-semibold text-gray-600 mb-1">Day</label>
                <select name="day" id="day"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                        <option value="{{ $day }}" {{ old('day', $timetable->day) === $day ? 'selected' : '' }}>
                            {{ $day }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="time_slot" class="block text-sm font-semibold text-gray-600 mb-1">Time Slot</label>
                <select name="time_slot" id="time_slot"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                    @foreach (['09:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00'] as $slot)
                        @php
                            $currentHour = (int) explode(':', explode('-', $timetable->time_slot)[0])[0];
                            $slotHour = (int) explode(':', explode('-', $slot)[0])[0];
                            $selected = old('time_slot') === $slot || (!old('time_slot') && $currentHour === $slotHour);
                        @endphp
                        <option value="{{ $slot }}" {{ $selected ? 'selected' : '' }}>
                            {{ $slot }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="table_number" class="block text-sm font-semibold text-gray-600 mb-1">Table Number</label>
                <select name="table_number" id="table_number"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                    @for ($i = 1; $i <= 30; $i++)
                        <option value="{{ $i }}" {{ (int) old('table_number', $timetable->table_number) === $i ? 'selected' : '' }}>
                            Table {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.mentor_students_timetable') }}"
                   class="text-sm text-gray-600 hover:underline">
                    &larr; Back to mentor timetables
                </a>
                <button type="submit" class="bg-[#7D3C98] text-white font-bold py-2 px-6 rounded-md">
                    Update Reservation
                </button>
            </div>
        </form>
    </div>
</x-layout>

<script>
    const scopeRadios = document.querySelectorAll('.scope-radio');
    const weekSelect = document.getElementById('week_number');

    function syncWeekState() {
        const selected = document.querySelector('.scope-radio:checked')?.value;
        weekSelect.disabled = selected !== 'week';
    }
    scopeRadios.forEach(r => r.addEventListener('change', syncWeekState));
    // If admin clicks the week dropdown, switch scope to "week" automatically.
    weekSelect.addEventListener('focus', () => {
        const weekRadio = document.querySelector('.scope-radio[value="week"]');
        if (weekRadio) {
            weekRadio.checked = true;
            syncWeekState();
        }
    });
    syncWeekState();

    const tableSelect = document.getElementById('table_number');
    const timeSelect = document.getElementById('time_slot');
    const dateSelect = document.getElementById('day');

    function updateTableOptions() {
        const selectedTime = timeSelect.value;
        const selectedDay = dateSelect.value;
        const currentValue = tableSelect.value;
        let tableCount = 12;

        if (selectedTime === '09:00-10:00' || selectedTime === '10:00-11:00') {
            tableCount = 2;
        }

        if (selectedTime === '15:00-16:00' || selectedTime === '16:00-17:00') {
            tableCount = 7;
        }

        if (selectedDay === 'Tuesday' && (selectedTime === '14:00-15:00')) {
            tableCount = 30;
        }

        if (selectedDay === 'Wednesday' && (selectedTime === '12:00-13:00' || selectedTime === '14:00-15:00' || selectedTime === '15:00-16:00')) {
            tableCount = 30;
        }

        tableSelect.innerHTML = '';
        for (let i = 1; i <= tableCount; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = 'Table ' + i;
            if (i === parseInt(currentValue, 10)) option.selected = true;
            tableSelect.appendChild(option);
        }
    }

    timeSelect.addEventListener('change', updateTableOptions);
    dateSelect.addEventListener('change', updateTableOptions);
</script>
