<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Reservation</h2>

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

        <form method="POST" action="{{ route('timetables.update') }}" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Day Selection -->
            <div>
                <label for="day" class="block text-sm font-semibold text-gray-600 mb-1">Day</label>
                <select name="day" id="day"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                        <option value="{{ $day }}" {{ $timetable->day === $day ? 'selected' : '' }}>
                            {{ $day }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Time Slot -->
            <div>
                <label for="time_slot" class="block text-sm font-semibold text-gray-600 mb-1">Time Slot</label>
                <select name="time_slot" id="time_slot"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                    @foreach (['09:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00', '17:00-18:00', '18:00-19:00', '19:00-20:00'] as $slot)
                        <option value="{{ $slot }}" {{ $timetable->time_slot === $slot ? 'selected' : '' }}>
                            {{ $slot }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Table Number -->
            <div>
                <label for="table_number" class="block text-sm font-semibold text-gray-600 mb-1">Table Number</label>
                <select name="table_number" id="table_number"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                    @for ($i = 1; $i <= 25; $i++)
                        <option value="{{ $i }}" {{ $timetable->table_number == $i ? 'selected' : '' }}>
                            Table {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700">
                    Update Reservation
                </button>
            </div>
        </form>
    </div>
</x-layout>
