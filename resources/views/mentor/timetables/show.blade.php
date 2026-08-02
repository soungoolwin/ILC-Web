<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">My Reserved Timetable</h2>

        @if (session('info'))
            <div class="bg-blue-100 text-blue-800 p-4 rounded-md mb-6">
                {{ session('info') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="border border-gray-200 rounded-lg p-4">
                <p class="text-xs font-semibold uppercase text-gray-500">Day</p>
                <p class="text-lg font-bold text-gray-800 mt-1">{{ $timetable->day }}</p>
            </div>
            <div class="border border-gray-200 rounded-lg p-4">
                <p class="text-xs font-semibold uppercase text-gray-500">Time Slot</p>
                @php
                    $start = explode('-', $timetable->time_slot)[0];
                    $hour = (int) explode(':', $start)[0];
                    $hourlySlot = sprintf('%02d:00-%02d:00', $hour, $hour + 1);
                @endphp
                <p class="text-lg font-bold text-gray-800 mt-1">{{ $hourlySlot }}</p>
            </div>
            <div class="border border-gray-200 rounded-lg p-4">
                <p class="text-xs font-semibold uppercase text-gray-500">Table Number</p>
                <p class="text-lg font-bold text-gray-800 mt-1">Table {{ $timetable->table_number }}</p>
            </div>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-md text-sm">
            To change your reserved day, time slot, or table number, please contact an admin in person.
        </div>
    </div>
</x-layout>
