<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Reserve Timetable</h2>

        <!-- Flash Message -->
        @if (session('info'))
            <div class="bg-blue-100 text-blue-800 p-4 rounded-md mb-6">
                {{ session('info') }}
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

        <form method="POST" action="{{ route('mentor.timetables.store') }}" class="space-y-5">
            @csrf

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
                    @foreach (range(9, 19) as $hour)
                        @php
                            $start_time = sprintf('%02d:00', $hour);
                            $end_time = sprintf('%02d:00', $hour + 1);
                        @endphp
                        <option value="{{ $start_time }}-{{ $end_time }}">
                            {{ $start_time }}-{{ $end_time }}
                        </option>
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
                    @foreach (range(1, 25) as $table)
                        <option value="{{ $table }}">Table {{ $table }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-between">
                <!-- Reserve Button -->
                <button type="submit"
                    class="bg-[#8E5C65] text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition">
                    Reserve Timetable
                </button>

                <!-- Check Availability Button -->
                <a href="{{ route('timetables.availability') }}"
                    class="bg-[#8E5C65] text-white font-bold py-3 px-4 rounded-lg shadow-lg transition">
                    Check Availability
                </a>
            </div>
        </form>
    </div>
</x-layout>
